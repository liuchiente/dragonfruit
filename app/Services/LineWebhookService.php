<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\FlexMessage;

use App\Models\LineMember;
use App\Models\LineGroup;
use App\Models\LineChat;
use App\Models\LineMessage;
use App\Models\LineCallingBell;
use App\Models\LineCard;
use App\Models\LineNotifyMessage;
use App\Models\LineNotifyTemplate;

use App\Service\PartsService;

use App\Models\Part;
use App\Models\Media;
use App\Models\News;
use App\Models\Orderh;
use App\Models\Orderd;
use App\Models\Orderp;
use App\Models\Inquiryh;
use App\Models\Inquiryd;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;


class LineWebhookService
{
    
    private $rule=null;
    private $calling=null;

    //1=User,2=Group
    const __CHAT_TYPE_USER=1;
    const __CHAT_TYPE_GROUP=2;

    const __QUERY_TYPE_PART=1; //商品
    const __QUERY_TYPE_MEDIA=2; //影片
    const __QUERY_TYPE_NEWS=3; //新聞
    const __QUERY_TYPE_INQUIRY=4; //詢價單
    const __QUERY_TYPE_ORDER=5; //訂單
    const __QUERY_TYPE_CALLING=6; //呼叫客服
    const __QUERY_TYPE_WELCOME_GROUP=7; //歡迎訊息(群組)
    const __QUERY_TYPE_WELCOME_JOIN_CHAT=8; //歡迎訊息(加入群組)
    const __QUERY_TYPE_WELCOME_JOIN_ME=9; //歡迎訊息(個人)

    private $empty='{"type":"bubble","body":{"type":"box","layout":"vertical","contents":[{"type":"image","url":"https://pixabay.com/get/gc6f4329da8e8d4ef0af875853423881cadb44d8152641abbec211cfcce63de6c43d4c9af212f85f62b05e8b698a50edbd4a761605883957d7be96909ff18cec5130419bf0bdd9818e143bdceef70c56e_640.jpg","size":"full","aspectMode":"cover","aspectRatio":"1:1","gravity":"center"},{"type":"box","layout":"vertical","contents":[],"position":"absolute","background":{"type":"linearGradient","angle":"0deg","endColor":"#00000000","startColor":"#00000099"},"width":"100%","height":"40%","offsetBottom":"0px","offsetStart":"0px","offsetEnd":"0px"},{"type":"box","layout":"horizontal","contents":[{"type":"box","layout":"vertical","contents":[{"type":"box","layout":"horizontal","contents":[{"type":"text","text":"找不到其他資料了","size":"xl","color":"#ffffff"}]}],"spacing":"xs"}],"position":"absolute","offsetBottom":"0px","offsetStart":"0px","offsetEnd":"0px","paddingAll":"20px"}],"paddingAll":"0px"}}';
    private $more='{
      "type": "bubble",
      "body": {
        "type": "box",
        "layout": "vertical",
        "spacing": "sm",
        "contents": [
          {
            "type": "button",
            "flex": 1,
            "gravity": "center",
            "action": {
              "type": "postback",
              "label": "<#more_tips>",
              "data": "q=<#query>&i=<#index>"
            }
          }
        ]
      }
    }';

    public function __construct() {
        
        $this->rule=[];
        $this->rule[(string)config('line.wenbhook_menu_news')]='responseMessageMemberNews';
        $this->rule[(string)config('line.wenbhook_menu_parts')]='responseMessageMemberParts';
        $this->rule[(string)config('line.wenbhook_menu_orders')]='responseMessageMemberOrders';
        $this->rule[(string)config('line.wenbhook_menu_video')]='responseMessageMemberVideo';
        $this->rule[(string)config('line.wenbhook_menu_user')]='responseMessageMemberUser';
        $this->rule[(string)config('line.wenbhook_menu_inquiry')]='responseMessageMemberInquirys';

        $this->calling=[];
        $this->calling['order']='訂貨';
        $this->calling['inquiry']='詢價';
        $this->calling['other']='其他';

    }

    /**
     * 一般使用者
     */
    public function entryMessageMember($message,$source){
        //訊息內容
        $text=$message->getText();
        //預設選項
        $method='';
        if($this->isMenuMessage($text)){
            $method=$this->rule[$text];
        }
        if($method==null||$method==''){
            $method='responseMessageMemberDefault';
        }
        return $this->$method($message,$source);
    }

    /**
     * 確認是不是菜單指令或保留訊息
     */
    private function isMenuMessage($text){
        return array_key_exists($text,$this->rule);
    }

    /**
     * 判斷是否保留訊息，紀錄Line傳入的訊息
     */
    public function entryMessageLogging($param){
        if(!($this->isMenuMessage($param['message_content']))){
            $this->logLineMessage($param);
        }
        return ;
    }

    /**
     * 紀錄Line傳入的訊息
     */
    private function logLineMessage($param){
        if(!($this->isMenuMessage($param['message_content']))){
            $lineMessage=new LineMessage();
            $lineMessage->line_type=$param['type'];
            $lineMessage->line_user_id=$param['user_id'];
            $lineMessage->line_user_type=$param['user_type'];
            $lineMessage->line_msg_type=$param['message_type'];
            $lineMessage->line_msg_content=$param['message_content'];
            $lineMessage->save();
        }
        return ;
    }

    public function entryMessageGroup($message){
        $method='';
        //訊息內容
        $text=$message->getText();
        if(array_key_exists($text,$this->rule)){
            $method=$this->rule[$text];
        }
        if($method==null||$method==''){
            $method='responseMessageGroupDefault';
        }
        return $this->$method($text);
    }

    /**
     * 文字訊息回應最新消息
     */
    public function responseMessageMemberNews($message,$source){
        $result=[];
        $msg=[];

        //取得對應的卡片
        $lineCard=LineCard::where('msg_type',self::__QUERY_TYPE_NEWS)->where('group_id',0)->first();
        $boxString=$lineCard->content;

        //取得對應消費者資料
        $lineMember=LineMember::where('line_user_id',$source->getUserId())->first();
        $line_user_name=($lineMember==null)?"":$lineMember->line_display_name;
        $uuid=str_replace('-','',(string)Str::orderedUuid());
        
        //替換卡片資料
        $msgbox=json_decode($boxString, true);
        $msgbox=$this->replaceInArray('<#user_name>',$line_user_name,$msgbox);
    
        //找到公告資料
        $news=News::where('publish_at','<=',Carbon::now())->skip(0)->take(10)->get();
                
        if(count($news)>0){

            //替換卡片資料
            $msgbox=json_decode($boxString, true);
            $contents=$msgbox['contents'];
            $bubble=[];
            $more=[];
            if($contents!=null&&count($contents)>0){
                $bubble=$contents[0];
                $more=$contents[1];
            }

            //開始組合卡片
            $new_bubbles=[];
            for($i=0;$i<count($news);$i++){
                $new=$news[$i];
                $new_bubble=$bubble;

                $new_bubble=$this->replaceInArray('<#title>',$new->subject,$new_bubble);
                $new_bubble=$this->replaceInArray('<#publisher>',$new->publisher,$new_bubble);
                $new_bubble=$this->replaceInArray('<#publish_date>',$new->publish_at,$new_bubble);
                $new_bubble=$this->replaceInArray('<#absract>',$new->content,$new_bubble);
                $new_bubble=$this->replaceInArray('<#link>',$new->link,$new_bubble);

                $new_bubbles[]=$new_bubble;
            }

            $new_bubbles[]=$more;
            $msgbox['contents']=$new_bubbles;
            $msg['contents']=$msgbox;

        }else{
            $msg['contents']=json_decode($this->empty);
        }

        $msg['type']='flex';
        $msg['altText']=$lineCard->subject;

        $result['reply']=true;
        $result['message']=$msg;
   
        return $result;
        
    }

    /**
     * 文字訊息回應商品資訊
     */
    public function responseMessageMemberParts($message,$source){
        $result=[];
        $msg=[];

        //取得對應的卡片
        $lineCard=LineCard::where('msg_type',self::__QUERY_TYPE_PART)->where('group_id',0)->first();
        $boxString=$lineCard->content;
        $vars=explode(',',$lineCard->variable);

        //取得對應消費者資料
        $lineMember=LineMember::where('line_user_id',$source->getUserId())->first();
        $line_user_name=($lineMember==null)?"":$lineMember->line_display_name;
        $uuid=str_replace('-','',(string)Str::orderedUuid());
        

        //商品服務
        $partsService=new PartsService();

        //找到商品資料
        $parts=$partsService->getList();
        
        if(count($parts)>0){

            //替換卡片資料
            $msgbox=json_decode($boxString, true);
            $contents=$msgbox['contents'];
            $bubble=[];
            $more=[];
            if($contents!=null&&count($contents)>0){
                $bubble=$contents[0];
                $more=$contents[1];
            }

            //開始組合卡片
            $cards=[];
            for($i=0;$i<count($parts);$i++){
                $part=$parts[$i];
                $card=$bubble;

                //分享索引
                $share_key = Str::random(6);
                //分享連結
                $shared=[];
                $shared[0]['type']="text";
                $shared[0]['text']="我在豐麟找到了\n\n『".$part->part_name."』，\n\n您也來看看！ \n ".$part->link;
                
                //$share_uri="https://liff.line.me/1661414135-95aMGZzm/share-j5gz?type=message&shared=".base64_encode(json_encode($shared));
                $share_uri="https://liff.line.me/1661414135-95aMGZzm/share-card?r=".$share_key;

                $additional=[];
                $additional['token']='XXX';
                $additional['share_uri']=$share_uri;
                $additional['user_name']=$line_user_name;
                $part_array=$part->getAttributes();
                $cards[]=$this->object2LineCard(array_merge($part_array,$additional),$vars,$card);
                
            }

            //更多資料
            $morebox=json_decode($this->more, true);
            $moretips=[];
            $moretips['more_tips']='更多商品';
            $moretips['query']='parts';
            $moretips['index']=1;
          
            $cards[]=$this->object2LineCard($moretips,array_keys($moretips),$morebox);

            $msgbox['contents']=$cards;
            $msg['contents']=$msgbox;

        }else{
            $msg['contents']=json_decode($this->empty);
        }

        $msg['type']='flex';
        $msg['altText']=$lineCard->subject;
        
        $result['reply']=true;
        $result['message']=$msg;
   
        return $result;
    }

    private function object2LineCard($obj_array,$var_array,$card){
        for($i=0;$i<count($var_array);$i++){
            $var=$var_array[$i];
            $target='<#'.$var.'>';
            if(isset($obj_array[$var])){
                $card=$this->replaceInArray($target,$obj_array[$var],$card);
            }
        }
        return $card;
    }

    private function object2LineText($obj,$template,$var_array){
        for($i=0;$i<count($var_array);$i++){
            $var=$var_array[$i];
            $target='<#'.$var.'>';
            $template=str_replace($target,$obj->$var,$template);
        }
        return $template;
    }

    /**
     * 文字訊息回應訂單
     */
    public function responseMessageMemberOrders($message,$source){
        $result=[];
        $msg=[];

        //取得對應的卡片
        $lineCard=LineCard::where('msg_type',self::__QUERY_TYPE_ORDER)->where('group_id',0)->first();
        $boxString=$lineCard->content;

        //取得對應消費者資料
        $lineMember=LineMember::where('line_user_id',$source->getUserId())->first();
        $line_user_name=($lineMember==null)?"":$lineMember->line_display_name;
        $uuid=str_replace('-','',(string)Str::orderedUuid());
        
        //找到商品資料
        /*$orders=Orderh::where('customer_id','<=',Carbon::now())->skip(0)->take(10)->get();

        if(count($orders)>0){

            //替換卡片資料
            $msgbox=json_decode($boxString, true);
            $contents=$msgbox['contents'];
            $bubble=[];
            $more=[];
            if($contents!=null&&count($contents)>0){
                $bubble=$contents[0];
                $more=$contents[1];
            }

        
            
            //開始組合卡片
            $part_bubbles=[];
            for($i=0;$i<count($parts);$i++){
                $part=$parts[$i];
                $part_bubble=$bubble;

                //分享連結
                $shared=[];
                $shared[0]['type']="text";
                $shared[0]['text']="我在豐麟找到了\n\n『".$part->part_name."』，\n\n您也來看看！ \n ".$part->link;
                $share_uri="https://liff.line.me/1661414135-95aMGZzm/share-j5gz?type=message&shared=".base64_encode(json_encode($shared));
                $part_bubble=$this->replaceInArray('<#share_uri>',$share_uri,$part_bubble);

                $part_bubble=$this->replaceInArray('<#part_img>',$part->thumb,$part_bubble);
                $part_bubble=$this->replaceInArray('<#part_name>',$part->part_name,$part_bubble);
                $part_bubble=$this->replaceInArray('<#part_no>',$part->part_no,$part_bubble);
                $part_bubble=$this->replaceInArray('<#part_brand>',$part->brand,$part_bubble);
                $part_bubble=$this->replaceInArray('<#part_price>',$part->price,$part_bubble);
                $part_bubble=$this->replaceInArray('<#part_uri>',$part->link,$part_bubble);

                $part_bubbles[]=$part_bubble;


            }
        
            $part_bubbles[]=$more;

            $msgbox['contents']=$part_bubbles;
            $msg['contents']=$msgbox;

        }else{
            $msg['contents']=json_decode($this->empty);
        }*/

        $msgbox=json_decode($boxString, true);
        $msg['contents']=$msgbox;
        $msg['type']='flex';
        $msg['altText']=$lineCard->subject;

        $result['reply']=true;
        $result['message']=$msg;
   
        return $result;
    }

    /**
     * 文字訊息回應影片
     */
    public function responseMessageMemberVideo($message,$source){
        $result=[];
        $msg=[];

        //取得對應的卡片
        $lineCard=LineCard::where('msg_type',self::__QUERY_TYPE_MEDIA)->where('group_id',0)->first();
        $boxString=$lineCard->content;

        //取得對應消費者資料
        $lineMember=LineMember::where('line_user_id',$source->getUserId())->first();
        $line_user_name=($lineMember==null)?"":$lineMember->line_display_name;
        $uuid=str_replace('-','',(string)Str::orderedUuid());
        
        //找到多媒體資料
        $medias=Media::where('publish_at','<=',Carbon::now())->skip(0)->take(10)->get();
        
        if(count($medias)>0){
            //替換卡片資料
            $msgbox=json_decode($boxString, true);
            $contents=$msgbox['contents'];
            $bubble=[];
            $more=[];
            if($contents!=null&&count($contents)>0){
                $bubble=$contents[0];
                $more=$contents[1];
            }
         
            //開始組合卡片
            $media_bubbles=[];
            for($i=0;$i<count($medias);$i++){
                $media=$medias[$i];
                $media_bubble=$bubble;
    
                //分享連結
                $shared=[];
                $shared[0]['type']="text";
                $shared[0]['text']="豐麟網站上有 \n\n『".$media->subject."』，\n\n您也來看看！ \n ".$media->link;
                $share_uri="https://liff.line.me/1661414135-95aMGZzm/share-j5gz?type=message&shared=".base64_encode(json_encode($shared));
                $media_bubble=$this->replaceInArray('<#share_uri>',$share_uri,$media_bubble);
    
                $media_bubble=$this->replaceInArray('<#thumb_uri>',$media->thumb,$media_bubble);
                $media_bubble=$this->replaceInArray('<#uri>',$media->link,$media_bubble);
                $media_bubble=$this->replaceInArray('<#title>',$media->subject,$media_bubble);
                $media_bubble=$this->replaceInArray('<#publisher>',$media->publisher,$media_bubble);
                $media_bubble=$this->replaceInArray('<#link_o>',$media->link,$media_bubble);
                $media_bubble=$this->replaceInArray('<#other_uri>',$media->link_r,$media_bubble);
    
                $media_bubbles[]=$media_bubble;
    
    
            }

            $more=$this->replaceInArray('<#more_tips>','更多影片',$more);
            $more=$this->replaceInArray('<#query>','media',$more);
            $more=$this->replaceInArray('<#index>',1,$more);
        
            $media_bubbles[]=$more;
    
            $msgbox['contents']=$media_bubbles;
            $msg['contents']=$msgbox;

        }else{
            $msg['contents']=json_decode($this->empty);
        }

        $msg['type']='flex';
        $msg['altText']=$lineCard->subject;

        $result['reply']=true;
        $result['message']=$msg;
   
        return $result;
    }

    /**
     * 文字訊息回應詢價單
     */
    public function responseMessageMemberInquirys($text){
        $result=[];
        $msg=[];

        //取得對應的卡片
        $lineCard=LineCard::where('msg_type',self::__QUERY_TYPE_INQUIRY)->where('group_id',0)->first();
        $boxString=$lineCard->content;

        //取得對應消費者資料
        $lineMember=LineMember::where('line_user_id',$source->getUserId())->first();
        $line_user_name=($lineMember==null)?"":$lineMember->line_display_name;
        $uuid=str_replace('-','',(string)Str::orderedUuid());
        
        //找到詢價單資料
        /*$inquiries=Inquiry::where('customer_id',$lineMember->customer_id)->skip(0)->take(10)->get();
        
        if(count($inquiries)>0){
            //替換卡片資料
            $msgbox=json_decode($boxString, true);
            $contents=$msgbox['contents'];
            $bubble=[];
            $more=[];
            if($contents!=null&&count($contents)>0){
                $bubble=$contents[0];
                $more=$contents[1];
            }
        
            //開始組合卡片
            $media_bubbles=[];
            for($i=0;$i<count($medias);$i++){
                $media=$medias[$i];
                $media_bubble=$bubble;
    
                //分享連結
                $shared=[];
                $shared[0]['type']="text";
                $shared[0]['text']="豐麟網站上有 \n\n『".$media->subject."』，\n\n您也來看看！ \n ".$media->link;
                $share_uri="https://liff.line.me/1661414135-95aMGZzm/share-j5gz?type=message&shared=".base64_encode(json_encode($shared));
                $media_bubble=$this->replaceInArray('<#share_uri>',$share_uri,$media_bubble);
    
                $media_bubble=$this->replaceInArray('<#thumb_uri>',$media->thumb,$media_bubble);
                $media_bubble=$this->replaceInArray('<#uri>',$media->link,$media_bubble);
                $media_bubble=$this->replaceInArray('<#title>',$media->subject,$media_bubble);
                $media_bubble=$this->replaceInArray('<#publisher>',$media->publisher,$media_bubble);
                $media_bubble=$this->replaceInArray('<#link_o>',$media->link,$media_bubble);
                $media_bubble=$this->replaceInArray('<#other_uri>',$media->link_r,$media_bubble);
    
                $media_bubbles[]=$media_bubble;
    
    
            }

            $more=$this->replaceInArray('<#more_tips>','更多影片',$more);
            $more=$this->replaceInArray('<#query>','media',$more);
            $more=$this->replaceInArray('<#index>',1,$more);
        
            $media_bubbles[]=$more;
    
            $msgbox['contents']=$part_bubbles;
            $msg['contents']=$msgbox;

        }else{
            $msg['contents']=json_decode($this->empty);
        }
*/

        $msg['type']='flex';
        $msg['altText']=$lineCard->subject;

        $msgbox=json_decode($boxString, true);
        $msg['contents']=$msgbox;
        
        $result['reply']=true;
        $result['message']=$msg;
   
        return $result;
    }



    

    /**
     * 文字訊息的預設回應方法
     */
    public function responseMessageMemberDefault($text){
        $result=[];
        $msg=[];
        
        $msg['type']='text';
        $msg['text']=$text;

        $result['reply']=false;
        $result['message']=$msg;
        return $result;
    }
  
    /**
     * 文字訊息的預設回應方法
     */
    public function responseMessageGroupDefault($text){
        $result=[];
        $result['type']='text';
        $result['text']=$text;
        return $result;
    }

    /** 
     * 更新Line使用者的紀錄  
     */
    public function updateLineMember($event){
        //取得事件相關人員, 如果使用者不存在, 則新增一筆紀錄
        $source=$event->getSource();
        $lineMember=LineMember::where('line_user_id',$source->getUserId())->first();
        if($lineMember==null&&$source->getUserId()!=""){
            $lineMember=new LineMember();
            $lineMember->line_user_id=$source->getUserId();
            $lineMember->line_display_name="";
            $lineMember->line_status_msg="";
            $lineMember->line_pic_url="";
            $lineMember->save();
        }
    }

    /**
     * 記錄把機器人加入群組
     * 如果群組紀錄不存在, 則新增一筆
     */
    public function updateLineGroup($source){
        $lineGroup=LineGroup::where('line_group_id',$source->getGroupId())->first();
        if($lineGroup==null&&$source->getGroupId()!=""){
            $lineGroup=new LineGroup();
            $lineGroup->line_group_id=$source->getGroupId();
            $lineGroup->line_display_name="";
            $lineGroup->line_pic_url="";
            $lineGroup->line_pic_url="";
            $lineGroup->line_pic_url="";
            $lineGroup->save();
        }
    }

    /**
     * 記錄把機器人離開群組
     */
    public function disableLineGroup($source){
        $source=$event->getSource();
        $lineGroup=LineGroup::where('line_group_id',$source->getGroupId())->first();
        if($lineGroup!=null){
            $lineGroup->exited_at=Carbon::createFromTimestamp($event->getTimestamp());
            $lineGroup->save();
        }
    }

    /**
     * 當使用者加入聊天,更新聊天紀錄
     */
    public function updateLineChat($event,$type){
        //取得事件相關人員, 如果使用者沒加入過聊天, 則新增一筆紀錄
        $source=$event->getSource();
        $lineChat=LineChat::where('line_group_id',$source->getGroupId())->where('line_user_id',$source->getUserId())->first();
        if($line_chat==null){
            $lineChat=new LineChat();
            $lineGroup->line_group_id=$source->getGroupId();
            $lineGroup->line_user_id=$source->getUserId();
            $lineGroup->type=$type;
            $lineGroup->joined_at=Carbon::createFromTimestamp($event->getTimestamp());
            $lineGroup->save();
        }
    }

    /**
     * 當使用者離開聊天,更新聊天紀錄
     */
    public function disableLineChat($event,$type){
       
    }

    /**
     * 更新或異動對話關係
     */
    private function getOrUpdateChat($user_id,$group_id){
        $lineChat=LineChat::where('line_group_id',$source->getGroupId())->where('line_user_id',$source->getUserId())->where('line_group_id',$source->getGroupId())->where('type',$type)->first();
        if($line_chat!=null){
            $lineGroup->leave_at=Carbon::createFromTimestamp($event->getTimestamp());
            $lineGroup->save();
        }
        return $lineChat;
    }

    /**
     * 更新或異動追蹤人
     */
    private function getOrUpdateCustomer($user_id,$group_id){
        $lineMember=LineMember::where('line_user_id',$source->getUserId())->first();
        if($lineMember==null&&$source->getUserId()!=""){
            $lineMember=new LineMember();
            $lineMember->line_user_id=$source->getUserId();
            $lineMember->line_display_name="";
            $lineMember->line_status_msg="";
            $lineMember->line_pic_url="";
            $lineMember->save();
        }
        return $lineMember;
    }

    /**
     * 使用者傳入訊息後，檢查是否提供呼叫按鈕
     * 1.如果距離上次提供呼叫時間，已經過了N分鐘
     * 2.如果上次提供的呼叫按鈕已經被使用
     */
    public function giveCallingbell($message,$source){
        $result=[];
        $msg=[];

        if($this->isMenuMessage($text=$message->getText())){
            $result['reply']=false;
            return $result;
        }

        $lineCallingBell=LineCallingBell::where('line_user_id',$source->getUserId())->where('expired_at',"<",Carbon::now())->where('used',0)->first();
        if($lineCallingBell==null){

            //發行新的呼叫憑證
            $lineCallingBell=new LineCallingBell();
            $lineCallingBell->expired_at=Carbon::now();
            $lineCallingBell->line_user_id=$source->getUserId();
            $lineCallingBell->used=0;
            $lineCallingBell->token=0;

            //$lineCallingBell->save();

            //取得對應的樣板
            $lineCard=LineCard::where('msg_type',self::__QUERY_TYPE_CALLING)->where('group_id',0)->first();
            $boxString=$lineCard->content;

            //取得對應消費者資料
            $lineMember=LineMember::where('line_user_id',$source->getUserId())->first();
            $line_user_name=($lineMember==null)?"":$lineMember->line_display_name;
            $uuid=str_replace('-','',(string)Str::orderedUuid());
            //替換樣本資料
            $msgbox=json_decode($boxString, true);
            $msgbox=$this->replaceInArray('<#user_name>',$line_user_name,$msgbox);
            $msgbox=$this->replaceInArray('<#token>',$uuid,$msgbox);
           
            
            foreach ($this->calling as $key => $value){
                $msgbox=$this->replaceInArray("<#label_$key>",$value,$msgbox);
                $msgbox=$this->replaceInArray("<#trigger_$key>",$key,$msgbox);
            }

            $msg['type']='flex';
            $msg['altText']=$lineCard->subject;


            //分享網址
            $shared=[];
            $shared[0]['type']="text";
            $shared[0]['text']="this is a test \n https://liuchien.ink.tw/";

            $share_uri="https://liff.line.me/1661414135-95aMGZzm/share-j5gz?type=message&shared=".base64_encode(json_encode($shared));
            $msgbox=$this->replaceInArray('<#share_uri>',$share_uri,$msgbox);

            $msg['contents']=$msgbox;
            $result['reply']=true;
            $result['message']=$msg;

        }else{
            $result['reply']=false;
        }        
        return $result;
        
    }

    /**
     * 替換卡片內容
     */
    private function replaceInArray($find, $replace, &$array) {
        array_walk_recursive($array, function(&$value) use($find, $replace) {
          if(str_contains($value, $find)){
            $value=str_replace($find, $replace, $value);
          }
        });
        return $array;
    }

    /**
     * 使用者回呼
     */
    public function entryPostback($user_id,$post_back){
      $result=[];
      $msg=[];
      $result['reply']=false;

      $post_back_cache = Cache::get("post_back@$user_id");
      if($post_back_cache==null){    
            $post_back_arr=json_decode($post_back['data'],true);
            if(array_key_exists($post_back_arr['query'],$this->calling)){

                $lineNotifyTemplate=LineNotifyTemplate::where('plain_type',2)->where('plan_status',1)->first();
                $message=$lineNotifyTemplate->plan_context;
                $message=str_replace('<#question>',$this->calling[$post_back_arr['query']],$message);
                $message=str_replace('<#user_name>','客戶',$message);


                $uuid=str_replace('-','',(string)Str::orderedUuid());
                $lineNotifyMessage=new LineNotifyMessage();
                $lineNotifyMessage->msg_id=$uuid;
                $lineNotifyMessage->msg_title=$lineNotifyTemplate->plan_title;
                $lineNotifyMessage->msg_context=$message;
                $lineNotifyMessage->plan_id=$lineNotifyTemplate->plan_id;
                $lineNotifyMessage->chl_id=$lineNotifyTemplate->plain_channel;
                $lineNotifyMessage->chl_type=1;
                $lineNotifyMessage->msg_status=1;
                $lineNotifyMessage->send_at=Carbon::now();
                $lineNotifyMessage->comment='Line Notify Plain Mesage';
                $lineNotifyMessage->save();
            }
            Cache::put("post_back@$user_id", 1 , Carbon::now()->addMinutes(1));
            $msg['type']='text';
            $msg['text']="已為您轉接客服人員，請稍候。";
            $result['reply']=true;
            $result['message']=$msg;
      
        }else{
            if($post_back_cache%15==1){
                $msg['type']='text';
                $msg['text']="客服人員正在趕來...請等一下。";
                $result['reply']=true;
                $result['message']=$msg;    
            }
            Cache::put("post_back@$user_id", $post_back_cache++ , Carbon::now()->addMinutes(1));
        }

      

      //$lineCallingBell=LineCallingBell::where('line_user_id',$source->getUserId())->where('expired_at',"<",Carbon::now())->where('used',0)->first();
      /*if($lineCallingBell==null){

          //發行新的呼叫憑證
          $lineCallingBell=new LineCallingBell();
          $lineCallingBell->expired_at=Carbon::now();
          $lineCallingBell->line_user_id=$source->getUserId();
          $lineCallingBell->used=0;
          $lineCallingBell->token=0;

          //$lineCallingBell->save();

          //取得對應的樣板
          $lineCard=LineCard::where('msg_type',1)->where('group_id',0)->first();
          $boxString=$lineCard->content;

          //取得對應消費者資料
          $lineMember=LineMember::where('line_user_id',$source->getUserId())->first();
          $line_user_name=($lineMember==null)?"":$lineMember->line_display_name;

          //替換樣本資料
          $msgbox=json_decode($boxString, true);
          $msgbox=$this->replace_in_array('<#user_mame>',$line_user_name,$msgbox);
          foreach ($this->calling as $key => $value){
              $msgbox=$this->replace_in_array("<#label_$key>",$value,$msgbox);
              $msgbox=$this->replace_in_array("<#trigger_$key>",$key,$msgbox);
          }

          $msg['type']='flex';
          $msg['altText']="";
          $msg['contents']=$msgbox;
          $result['reply']=true;
          $result['message']=$msg;

      }else{
          $result['reply']=false;
      }*/

     

      return $result;  
    }

}