<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\FlexMessage;

use App\Models\LineMember;
use App\Models\LineGroup;
use App\Models\LineChat;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;


class LineWebhookService
{
    
    private $rule=null;

    //1=User,2=Group
    const __CHAT_TYPE_USER=1;
    const __CHAT_TYPE_GROUP=2;


    public function __construct() {
        $this->rule=[];
        $this->rule[(string)config('line.wenbhook_menu_news')]='responseMessageGroupNews';
        $this->rule[(string)config('line.wenbhook_menu_parts')]='responseMessageGroupParts';
        $this->rule[(string)config('line.wenbhook_menu_orders')]='responseMessageGroupOrders';
        $this->rule[(string)config('line.wenbhook_menu_video')]='responseMessageGroupVideo';
        $this->rule[(string)config('line.wenbhook_menu_user')]='responseMessageGroupUser';
    }

    /**
     * 一般使用者
     */
    public function entryMessageMember($message){
        //訊息內容
        $text=$message->getText();
        //預設選項
        $method='';
        if(array_key_exists($text,$this->rule)){
            $method=$this->rule[$text];
        }
        if($method==null||$method==''){
            $method='responseMessageDefault';
        }
        return $this->$method($text);
    }

    public function entryMessageGroup($message){
        $method='';
        //訊息內容
        $text=$message->getText();
        Log::info(json_encode(($this->rule)));;
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
    public function responseMessageGroupNews($text){
        
    }

    /**
     * 文字訊息回應商品資訊
     */
    public function responseMessageGroupParts($text){
    }

    /**
     * 文字訊息回應訂單
     */
    public function responseMessageGroupOrders($text){
    }

    /**
     * 文字訊息回應影片
     */
    public function responseMessageGroupVideo($text){
    }


    /**
     * 文字訊息的預設回應方法
     */
    public function responseMessageDefault($text){
        $result=[];
        $result['type']='text';
        $result['text']=$text;
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
            $lineGroup->line_group_id=$source->getUserId();
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
        $lineChat=LineChat::where('line_group_id',$source->getGroupId())->where('line_user_id',$source->getUserId())->where('line_group_id',$source->getGroupId())->where('type',$type)->first();
        if($line_chat!=null){
            $lineGroup->leave_at=Carbon::createFromTimestamp($event->getTimestamp());
            $lineGroup->save();
        }
    }


}