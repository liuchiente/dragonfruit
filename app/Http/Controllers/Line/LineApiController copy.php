<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;

use \LINE\Clients\MessagingApi\Configuration;
use \LINE\Constants\HTTPHeader;
use \LINE\Parser\EventRequestParser;
use \LINE\Parser\Exception\InvalidEventRequestException;
use \LINE\Parser\Exception\InvalidSignatureException;

use \LINE\Clients\MessagingApi\Api\MessagingApiApi;

use \LINE\Webhook\Model\TextMessageContent;

use \LINE\Webhook\Model\ImageMessageContent;
use \LINE\Webhook\Model\VideoMessageContent;
use \LINE\Webhook\Model\AudioMessageContent;
use \LINE\Webhook\Model\FileMessageContent;
use \LINE\Webhook\Model\LocationMessageContent;
use \LINE\Webhook\Model\StickerMessageContent;

use \GuzzleHttp\Client;

use \LINE\Webhook\Model\UserSource;
use \LINE\Webhook\Model\GroupSource;
use \LINE\Webhook\Model\RoomSource;

use \LINE\Webhook\Model\MessageEvent;
use \LINE\Webhook\Model\UnsendEvent;
use \LINE\Webhook\Model\FollowEvent;
use \LINE\Webhook\Model\UnfollowEvent;
use \LINE\Webhook\Model\JoinEvent;
use \LINE\Webhook\Model\LeaveEvent;
use \LINE\Webhook\Model\PostbackEvent;
use \LINE\Webhook\Model\VideoPlayCompleteEvent;
use \LINE\Webhook\Model\BeaconEvent;
use \LINE\Webhook\Model\AccountLinkEvent;
use \LINE\Webhook\Model\MemberJoinedEvent;
use \LINE\Webhook\Model\MemberLeftEvent;
use \LINE\Webhook\Model\ThingsEvent;
use \LINE\Webhook\Model\ModuleEvent;
use \LINE\Webhook\Model\ActivatedEvent;
use \LINE\Webhook\Model\DeactivatedEvent;
use \LINE\Webhook\Model\BotSuspendedEvent;
use \LINE\Webhook\Model\BotResumedEvent;
use \LINE\Webhook\Model\PnpDeliveryCompletionEvent;



use App\Services\LineWebhookService;
use App\Services\LineFlexMessageService;


class LineApiController extends Controller
{
    public function alive(Request $request)
    {
      return response()->json([]);
    }


    /**
     * Line Bot Entrypoint
     * 1. Menu
     */
    public function bob(Request $request)
    {
        //檢查標頭是否正確
        $signature = $request->header(HTTPHeader::LINE_SIGNATURE);
        if ($signature==null||$signature=="") {
            return response('Bad Request', 400);
        }

        //新增Client, 實際回應請求時, 會先呼叫Line Server
        $client = new Client();
        $config = new Configuration();
        $secret = config('line.channel_bob_secret');
        $config->setAccessToken(config('line.channel_bob_token'));
        $messagingApi = new MessagingApiApi(
            client: $client,
            config: $config,
        );

        //測試檢查傳入請求內容
        Log::info('Line Post Request', [
            'request' => serialize($request->all())
        ]);

        //處理傳入的請求內容
        try {
            $bodyContent = $request->getContent();
            $parsedEvents = EventRequestParser::parseEventRequest($bodyContent, $secret, $signature);
        } catch (InvalidSignatureException $e) {
            return response('Invalid signature', 400);
        } catch (InvalidEventRequestException $e) {
            return response('Invalid event request', 400);
        }


         //解析封包, 並分派資料處理入口
        foreach ($parsedEvents->getEvents() as $event) {
            //呼叫服務
            $lineWebhookService=new LineWebhookService();

            //判斷對話來源
            $source=$event->getSource();

            if($source instanceof UserSource){
                //一般對話

                if ($event instanceof MessageEvent){

                    //取得訊息內下
                    $message = $event->getMessage();

                    //使用者代號、對話類型、群組代號
                    $user_id=$source->getUserId();
                    $user_type=$source->getType();
                    $group_id="";

                    //一般文字訊息
                    $responsePayload=[];

                    //訊息處理
                    $response = $lineWebhookService->entryMessageMember($message,$source);
                    //如果訊息存在的話, 放進封裝裡面等待回傳
                    if(isset($response['reply'])&&($response['reply'])){
                        $responsePayload[]=$response['message'];
                    }

                    //呼叫客服
                    $response = $lineWebhookService->giveCallingbell($message,$source);
                    //如果訊息存在的話, 放進封裝裡面等待回傳
                    if(isset($response['reply'])&&($response['reply'])){
                        $responsePayload[]=$response['message'];
                    }

                    Log::info(json_encode($responsePayload));

                    //針對每個請求回應
                    $messagingApi->replyMessage(new ReplyMessageRequest([
                        'replyToken' => $event->getReplyToken(),
                        'messages' =>$responsePayload,
                    ]));

                   
                    //紀錄訊息
                    $source=$event->getSource();
                    $messag_loggin=[];
                    $messag_loggin['type']="message";
                    $messag_loggin['user_id']=$source->getUserId();
                    $messag_loggin['user_type']=$source->getType();
                    $messag_loggin['message_type']="text";
                    $messag_loggin['message_content']=$message->getText();
                    $lineWebhookService->entryMessageLogging($messag_loggin);

                }else if ($event instanceof FollowEvent){
                    //追蹤
                    //記錄會員已追蹤    
                    $lineWebhookService->updateLineMember($event);
                    $lineWebhookService->updateLineChat($event,LineWebhookService::__CHAT_TYPE_USER);
                }else if ($event instanceof UnfollowEvent){
                    //退追蹤
                    //記錄使用者已經退追蹤
                    $lineWebhookService->disableLineChat($event,LineWebhookService::__CHAT_TYPE_USER);
                    
                }else if ($event instanceof PostbackEvent){
                    //POSTBACK
                    $user_id=$source->getUserId();
                    $post_back = $event->getPostback();

                    $response = $lineWebhookService->entryPostback($user_id,$post_back);
                    //如果訊息存在的話, 放進封裝裡面等待回傳
                    if(isset($response['reply'])&&($response['reply'])){
                        $responsePayload[]=$response['message'];
                    }
                   
                    //針對每個請求回應
                    $messagingApi->replyMessage(new ReplyMessageRequest([
                        'replyToken' => $event->getReplyToken(),
                        'messages' =>$responsePayload,
                    ]));

                }else {
                    Log::info('Non User message event has come');
                    continue;
                }

            }else if($source instanceof GroupSource){
            //群組對話
            
                if ($event instanceof MessageEvent){
                    //訊息
                        $message = $event->getMessage();
                        $responsePayload = $lineWebhookService->entryMessageGroup($message);
                        //針對每個請求回應
                        $messagingApi->replyMessage(new ReplyMessageRequest([
                            'replyToken' => $event->getReplyToken(),
                            'messages' => [
                                $responsePayload
                            ],
                        ]));

                        //紀錄訊息
                        $source=$event->getSource();
                        $messag_loggin=[];
                        $messag_loggin['type']="message";
                        $messag_loggin['user_id']=$source->getUserId();
                        $messag_loggin['user_type']=$source->getType();
                        $messag_loggin['message_type']="text";
                        $messag_loggin['message_content']=$message->getText();
                        $lineWebhookService->entryMessageLogging($messag_loggin);

                    }else if ($event instanceof JoinEvent){
                    //加入對話
                        //訊息處理
                        $lineFlexMessageService=new LineFlexMessageService();
                        //記錄群組 
                        $lineWebhookService->updateLineGroup($source);
                        $responsePayload=lineFlexMessageService->responseMessageWelcomeGroup();
                        //針對每個請求回應
                        $messagingApi->replyMessage(new ReplyMessageRequest([
                        'replyToken' => $event->getReplyToken(),
                        'messages' => [
                            $responsePayload
                            ],
                        ]));
                    }else if ($event instanceof LeaveEvent){
                    //離開對話
                        //紀錄機器人已經被離開群組
                        $lineWebhookService->disableLineGroup($event);
                    }else if ($event instanceof MemberJoinedEvent){
                    //成員加入對話
                        //記錄會員已經加入群組    
                        $lineWebhookService->updateLineMember($event);
                        $lineWebhookService->updateLineChat($event,LineWebhookService::__CHAT_TYPE_GROUP);
                    }else if ($event instanceof MemberLeftEvent){
                        //成員離開對話
                        //記錄使用者已經退群組
                        $lineWebhookService->disableLineChat($event,LineWebhookService::__CHAT_TYPE_GROUP);
                    }else if ($event instanceof PostbackEvent){
                    //POSTBACK
                        Log::info('Non message event has come');
                        continue;
                    }else {
                        Log::info('Non User message event has come');
                        continue;
                    }
                    
            }else if($source instanceof RoomSource){
            //多人對話
                Log::info('Room message has come');
                continue;
            }else{
                Log::info('Non message has come');
                continue;
            }
    
            //追蹤
            /*if (!($message instanceof TextMessageContent)) {
                Log::info('Non message event has come');
                continue;
            }*/
            
        }

        return response('Hello World', 200);
    }
}
