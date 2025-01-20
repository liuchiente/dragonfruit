<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Services\LineCardService;
use App\Services\LineCardCarousellRenderService;


/**
 *  商品頁面
 */
class ProductController extends Controller{

    /**
     * 查詢商品清單
     */
    public function getList(Request $request) {
        $lineCardCarousellRenderService=new LineCardCarousellRenderService();
        $ctx=json_decode($request->getContent(), true);
        return $lineCardCarousellRenderService->render($ctx);
    }

    /**
     * 查看商品詳細資料
     */
    public function getOne(Request $request) {
        $lineCardCarousellRenderService=new LineCardCarousellRenderService();
        $ctx=json_decode($request->getContent(), true);
        return $lineCardCarousellRenderService->render($ctx);
    }
    
}
