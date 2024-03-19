<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\FlexMessage;

use App\Models\LineMember;
use App\Models\LineGroup;
use App\Models\LineChat;


class LineFlexMessageService
{
    
    private $rule=null;

    //1=User,2=Group
    const __CHAT_TYPE_USER=1;
    const __CHAT_TYPE_GROUP=2;


    public function __construct() {
        $this->rule=[];
        $this->rule[config('line.wenbhook_menu_news')]='responseMessageNews';
        $this->rule[config('line.wenbhook_menu_parts')]='responseMessagePart';
        $this->rule[config('line.wenbhook_menu_orders')]='responseMessageOrder';
        $this->rule[config('line.wenbhook_menu_video')]='responseMessageMedia';
        $this->rule[config('line.wenbhook_menu_user')]='responseMessageGroupUser';
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
            $method='responseMessage';
        }
        return $this->$method($text);
    }

    public function entryMessageGroup($text){
        $method='';
        if(array_key_exists($text,$this->rule)){
            $method=$this->rule[$text];
        }
        if($method==null||$method==''){
            $method='responseMessageGroup';
        }
        return $this->$method($text);
    }

   
   
    /**
     * 提示註冊
     */
    public function responseMessageRegister($event){
        $defaultWrapper = Storage::json('app/line/registerGroup.json');    
    }

    /**
     * 影片
     */
    public function responseMessageMedia($event){
      $defaultWrapper = Storage::json('app/line/registerGroup.json');    
    }

    /**
     * 商品
     */
    public function responseMessagePart($event){
        $defaultWrapper = Storage::json('app/line/part.json');    
    }

    /**
     * 新聞
     */
    public function responseMessageNews($event){
      $defaultWrapper = Storage::json('app/line/news.json');    
    }

    /**
     * 群組歡迎訊息
     */
    public function responseMessageWelcomeGroup($event){
      $defaultWrapper = Storage::json('app/line/welcomeGroup.json');    
    }

    /**
     * 個人歡迎訊息
     */
    public function responseMessageWelcomeUser($event){
      $defaultWrapper = Storage::json('app/line/welcomeUser.json');    
    }

     /**
     * 個人歡迎訊息
     */
    public function responseMessageOrder($event){
      $defaultWrapper = Storage::json('app/line/welcomeUser.json');    
    }
 
}