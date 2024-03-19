<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\FlexMessage;

use App\Models\LineMember;
use App\Models\LineGroup;
use App\Models\LineChat;

class LineWebhookService
{
    
    private $rule=null;

    //1=User,2=Group
    const __CHAT_TYPE_USER=1;
    const __CHAT_TYPE_GROUP=2;


    public function __construct() {
        $this->rule=[];
        $this->rule[config('line.wenbhook_menu_news')]='responseMessageGroupNews';
        $this->rule[config('line.wenbhook_menu_parts')]='responseMessageGroupParts';
        $this->rule[config('line.wenbhook_menu_orders')]='responseMessageGroupOrders';
        $this->rule[config('line.wenbhook_menu_video')]='responseMessageGroupVideo';
        $this->rule[config('line.wenbhook_menu_user')]='responseMessageGroupUser';
    }

    /**
     * 一般使用者
     */
    public function entryMessageUser($message){
        //訊息內容
        $text=$message->getText();




        $method='';
        if(array_key_exists($text,$this->rule)){
            $method=$this->rule[$text];
        }
        if($method==null||$method==''){
            $method='respDefualt';
        }
        return $this->$method($text);
    }

    public function entryMessageGroup($text){
        $method='';
        if(array_key_exists($text,$this->rule)){
            $method=$this->rule[$text];
        }
        if($method==null||$method==''){
            $method='responseMessageGroupDefualt';
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
    public function responseMessageGroupDefault($text){
        $result=[];
        $result['type']='text';
        $result['text']=$text;
        return $result;
    }

    public function checkLineMember($source){
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

    public function checkLineGroup($source){
        $lineGroup=LineGroup::where('line_group_id',$source->getGroupId())->first();
        if($lineGroup==null&&$source->getGroupId()!=""){
            $lineGroup=new LineGroup();
            $lineGroup->line_group_id=$source->getUserId();
            $lineGroup->line_display_name="";
            $lineGroup->line_pic_url="";
            $lineGroup->save();
        }
    }

    public function checkLineChat($source,$type,$time){
        $lineChat=LineChat::where('line_group_id',$source->getGroupId())->where('line_user_id',$source->getUserId())->first();
        if($line_chat==null){
            $lineChat=new LineChat();
            $lineGroup->line_group_id=$source->getUserId();
            $lineGroup->line_user_id=$source->getUserId();
            $lineGroup->type=$type;
            $lineGroup->d_leave=$time;
            $lineGroup->save();
        }
    }
}