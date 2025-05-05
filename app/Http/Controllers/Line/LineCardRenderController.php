<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Services\LineCardService;
use App\Services\LineCardCarousellRenderService;


class LineCardRenderController extends Controller{





    public function render(Request $request) {
        $lineCardCarousellRenderService=new LineCardCarousellRenderService();
        $ctx=json_decode($request->getContent(), true);
        return $lineCardCarousellRenderService->render($ctx);
    }
    
}
