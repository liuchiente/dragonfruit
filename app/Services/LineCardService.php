<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Models\LineCardTemplate;
use App\Models\LineCard;


class LineCardService
{

    private const _MODEL=[
        1=>"Line名片",
        2=>"聊天機器人"
    ];

    private const _TYPE=[
        1=>"多卡片輪播",
        2=>"單一數位卡片"
    ];

    public const _IS_SUCESSS=1;
    public const _IS_FAIL=-1;

    private function getDesigner($val){
        $_DESIGNER=[
            1=>route('line.card.carousel1'),
            2=>route('line.card.cv1')
        ];
        return isset($_DESIGNER[$val])?$_DESIGNER[$val]:"#";
    }

    private function getBase64Encode($str){
        return base64_encode($str);
    }

    public function getTemplates($query){
        $templates=[];
        $templates = collect(LineCardTemplate::get());
        $templates->map(function ($asset) {
            $asset->model_name=isset(self::_MODEL[$asset->model])?self::_MODEL[$asset->model]:"";
            $asset->type_name=isset(self::_TYPE[$asset->type])?self::_TYPE[$asset->type]:"";
            $typee=$this->getBase64Encode($asset->type);
            $templatee=$this->getBase64Encode($asset->id);
            $asset->designer=$this->getDesigner($asset->type)."?type=$typee&template=$templatee";
            return $asset;

        });
        return $templates;
    }

    /**
     * Line 卡片設計器模板
     */
    public function getTemplate($query){
        $result=[];
        $query['template']=!isset($query['template'])||$query['template']==""?0:$query['template'];
        $query['type']=!isset($query['type'])||$query['type']==""?0:$query['type'];
        if($query['type']!=0){
            $linecardtemplate=LineCardTemplate::where("id",$query['template'])->where("type",$query['type'])->first();
            $result['sample']=$linecardtemplate->sample;
            $result['id']=$linecardtemplate->id;
            $result['type']=$linecardtemplate->type;
            $result['model']=$linecardtemplate->model;
            $result['link']=$linecardtemplate->link;
        }
        return $result;
    }

    /**
     * Line 卡片
     */
    public function getCard($query){
        $result['id']=0;
        $result['content']="";

        $linecard=LineCard::where("id",$query['card_no'])->where("user_id",$query['user_id'])->first();
        $result['id']=$linecard->id;
        $result['sample']=$linecard->template;
        $result['subject']=$linecard->subject;
        
        return $result;
    }

    /**
     * 取得會員的所有卡片
     */
    public function getCards($query,$user){
        $cards=LineCard::select('line_cards.*','line_card_templates.type','line_card_templates.model')->join('line_card_templates', 'line_cards.template_id', '=', 'line_card_templates.id')
        ->where("line_cards.user_id",$user->id)->get();
        $cards->map(function ($asset) {
            $cardno=$this->getBase64Encode($asset->id);
            $asset->model_name=isset(self::_MODEL[$asset->model])?self::_MODEL[$asset->model]:"";
            $asset->type_name=isset(self::_TYPE[$asset->type])?self::_TYPE[$asset->type]:"";
            $asset->designer=$this->getDesigner($asset->type)."?cardno=$cardno";
            $asset->cardno=$this->getBase64Encode($asset->id);
            return $asset;
        });
        return $cards;
    }

    /**
     * 取得所有會員已經共享的卡片
     */
    public function getSharedCards($query,$user){
        $cards=LineCard::select('line_cards.*','line_card_templates.type','line_card_templates.model','users.name')->join('line_card_templates', 'line_cards.template_id', '=', 'line_card_templates.id')
        ->join('users', 'line_cards.user_id', '=', 'users.id')
        ->where("line_cards.shared",1)->get();
        $cards->map(function ($asset) {
            $cardno=$this->getBase64Encode($asset->id);
            $asset->model_name=isset(self::_MODEL[$asset->model])?self::_MODEL[$asset->model]:"";
            $asset->type_name=isset(self::_TYPE[$asset->type])?self::_TYPE[$asset->type]:"";
            $asset->designer=$this->getDesigner($asset->type)."?cardno=$cardno";
            $asset->cardno=$this->getBase64Encode($asset->id);
            $asset->user_name=$asset->name;
            return $asset;
        });
        return $cards;
    }

    /**
     * 儲存個人卡片設定
     */
    public function saveCards($card,$user){
        $result=[];
        if(isset($card['cardno'])&&$card['cardno']!=""&&$card['cardno']!="0"){
            //edit
            $lineCard=LineCard::where("id",$card['cardno'],)->where("user_id",$user->id)->first();
        }else{
            $lineCard=new LineCard();
        }
        //$lineCard->template_id=$card['template'];
        $lineCard->subject=$card['subject'];
        $lineCard->content =$card['exports'];
        $lineCard->shared=0;
        $lineCard->user_id=$user->id;
        $lineCard->group_id=0;
        $lineCard->msg_type=0;
        
        $lineCard->save();

        $result['cardno']=$lineCard->id;
        return $result;
    }

     /**
     * 刪除個人卡片
     */
    public function removeCards($card,$user){
        $userId=1;
        $lineCard=new LineCard();
        $work=new WorkService(self::_IS_SUCESSS);
        if(isset($card['cano'])&&$card['cano']!=""&&$card['cano']!="0"){
            //edit
            $lineCard=LineCard::where("id",$card['cano'],)->where("user_id",$userId)->first();
            $lineCard->delete();
            $work->setCode(self::_IS_SUCESSS);
        }else{
            $work->setCode(self::_IS_FAIL);
        }
        return $work;
    }


    /**
     * 分享卡片
     * 傳入卡片代號、使用者代號找到對應的卡片
     */
    public function shareCardStore($param,$user){
        $result=[];
        $result["done"]=false;
        if(isset($param['card'])&&$param['card']!=""&&$param['card']!="0"){
            $share=isset($param['share'])&&$param['share']==true?1:0;
            $lineCard=LineCard::where("id",$param['card'],)->where("user_id",$user->id)->first();
            if($lineCard!=null){
                $lineCard->share=$share;
                $lineCard->save();
                $result["done"]=true;
            }
        }
        return $result;
    }
    

}