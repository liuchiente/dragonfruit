<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Services\LineCardService;
use App\Services\LineCardCarousellRenderService;

/**
 * 購物車頁面
 */
class CartController extends Controller{

    protected $cartService;

    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }

    /**
     * 新增商品到購物車
     */
    public function addOne(Request $request) {
       // 取得請求的 body，並轉換為 JSON
       $data = $request->getContent();
        
       // 嘗試解析 JSON
       $parsedData = json_decode($data, true);

       // 檢查 JSON 解析是否成功
       if (json_last_error() !== JSON_ERROR_NONE) {
           return response()->json(['error' => 'Invalid JSON'], 400);
       }

       // 假設這裡要取出的 part_id 和 count
       $partId = $parsedData['part_id'] ?? null;
       $count = $parsedData['count'] ?? null;

       // 使用 CartService 的 addOne 方法
       $result = $this->cartService->addOne($partId, $count);

       // 返回 JSON 回應
       return response()->json([$result]);
    }

    /**
     * 刪除購物車商品
     */
    public function delOne(Request $request) {
        // 取得請求的 body，並轉換為 JSON
        $data = $request->getContent();
        
        // 嘗試解析 JSON
        $parsedData = json_decode($data, true);

        // 檢查 JSON 解析是否成功
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON'], 400);
        }

        // 假設這裡要取出的 part_id 和 count
        $partId = $parsedData['part_id'] ?? null;
        $count = $parsedData['count'] ?? null;

        // 使用 CartService 的 delOne 方法
        $result = $this->cartService->delOne($partId, $count);

        // 返回 JSON 回應
        return response()->json([$result]);
    }

    /**
     * 重算購物車內商品小計
     */
    public function checkOut(Request $request) {
        // 取得請求的 body，並轉換為 JSON
        $data = $request->getContent();
        
        // 嘗試解析 JSON
        $parsedData = json_decode($data, true);

        // 檢查 JSON 解析是否成功
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON'], 400);
        }

        // 假設這裡要取出的 part_id 和 count
        $partId = $parsedData['part_id'] ?? null;
        $count = $parsedData['count'] ?? null;

        // 使用 CartService 的 delOne 方法
        $result = $this->cartService->delOne($partId, $count);

        // 返回 JSON 回應
        return response()->json([$result]);
    }

}
