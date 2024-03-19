<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\LineCardService;




class LineCardController extends Controller{

    /**
     * host/templates
     */
    public function template(Request $request){
        $result['is_done']='F';
        $lineCardService=new LineCardService();
        $template=$lineCardService->getTemplate($request->only('template','type'));
        if(isset($template['id'])){
            $result['is_done']='T';
            $result['data']=$template;
        }
        return $result;
    }

    public function templatesShow(Request $request){
        $lineCardService=new LineCardService();
        $templates=$lineCardService->getTemplates([]);
        return view('page.templates',['templates'=>$templates]);
    }

    public function cardStore(Request $request){

        $payload['is_done']='F';

        $request->validate([
            'params.template' => ['required', 'numeric'],
            'params.cardno' => ['required', 'numeric'],
            'params.exports' => ['required'],
            'params.subject' => ['required'],
            'params.type' => ['required', 'numeric'],
        ]);

        $user=Auth::user();
        $lineCardService=new LineCardService();
        //save cards
        $result=$lineCardService->saveCards($request->only('params')['params'],$user);
        if(isset($result['cardno'])){
            $payload['is_done']='T';
            $payload['cardno']=$result['cardno'];
        }

        return $payload;
    }

    public function templateStore(Request $request)
    { 
        return back()->with('status', 'verification-link-sent');
    }

    public function cardsShow(Request $request){
        $lineCardService=new LineCardService();
        $user=Auth::user();
        $cards=$lineCardService->getCards([],$user);
        return view('page.cards',['cards'=>$cards]);
    }

    public function card(Request $request){
        $lineCardService=new LineCardService();
        return $lineCardService->getCard($request->only('tano'));
    }

    public function carousel1(Request $request){
        return view('cano.forms.line-carousel-1');
    }

    public function cv1(Request $request){
        return view('cano.forms.psprint-3949');
    }

}
