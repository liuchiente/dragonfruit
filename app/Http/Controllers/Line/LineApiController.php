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
            return $res->withStatus(400, 'Bad Request');
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
            return $res->withStatus(400, 'Invalid signature');
        } catch (InvalidEventRequestException $e) {
            return $res->withStatus(400, "Invalid event request");
        }

         //解析封包, 並分派入口
        foreach ($parsedEvents->getEvents() as $event) {
            //呼叫服務
            $lineWebhookService=new LineWebhookService();

            //判斷訊息
            $message = $event->getMessage();
            //判斷對話來源
            $source=$event->getSource();

            if($source instanceof UserSource){
                //一般對話

                if ($event instanceof MessageEvent){
                    //訊息
                    Log::info('User MessageEventt has come');

                    $responsePayload = $lineWebhookService->entryMessageMember($message);
                    //針對每個請求回應
                    $messagingApi->replyMessage(new ReplyMessageRequest([
                        'replyToken' => $event->getReplyToken(),
                        'messages' => [
                            $responsePayload
                        ],
                    ]));

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
                    Log::info('Non message event has come');
                    continue;
                }else {
                    Log::info('Non User message event has come');
                    continue;
                }

            }else if($source instanceof GroupSource){
            //群組對話
            
                if ($event instanceof MessageEvent){
                    //訊息
                        $responsePayload = $lineWebhookService->entryMessageGroup($message);
                        //針對每個請求回應
                        $messagingApi->replyMessage(new ReplyMessageRequest([
                            'replyToken' => $event->getReplyToken(),
                            'messages' => [
                                $responsePayload
                            ],
                        ]));
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
            if (!($message instanceof TextMessageContent)) {
                Log::info('Non message event has come');
                continue;
            }
            
        }

        return response()->json([]);
    }
}
