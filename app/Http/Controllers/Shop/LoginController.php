<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Services\LineCardService;
use App\Services\LineCardCarousellRenderService;

/**
 * 登入頁面
 */
class LoginController extends Controller{

    public function auth(Request $request) {
        $lineCardCarousellRenderService=new LineCardCarousellRenderService();
        $ctx=json_decode($request->getContent(), true);
        return $lineCardCarousellRenderService->render($ctx);
    }
    
}
