<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\OrdersService;
use App\Services\InquiryService;

class OrderController extends Controller
{

    protected $ordersService,$inquiryService;

    public function __construct(OrdersService $ordersService,InquiryService $inquiryService)
    {
        $this->ordersService = $ordersService;
        $this->inquiryService = $inquiryService;
    }

    public function orderList(Request $request)
    {
        // 從查詢字串獲取參數
        $params = [
            'orderBy' => $request->query('o'),
            'asc' => $request->query('a'),
            'row' => $request->query('r'),
            'page' => $request->query('p'),
            'query' => $request->query('q'),
        ];

        $result = [
            'data' => null,
            'is_done' => 'F',
        ];

        try {
            // 調用 OrderService 的 getList 方法
            $orderItems = $this->ordersService->getList($params);
             // 重新組合資料
            $data = [];
            foreach ($orderItems['data'] as $item) {
                $data[] = [
                    'id' => $item['id'],
                    'order_from' => $item['order_from'],
                    'order_no' => $item['order_no'],
                    'order_date' => $item['order_date'],
                    'customer_no' => $item['customer_no'],
                    'customer_name' => $item['customer_name'],
                    'ship_contact' => $item['ship_contact'],
                    'ship_date' => $item['ship_date'],
                    'amount' => $item['amount'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                    // 根據需求添加其他屬性
                ];
            }

            $result = [
                'data' => $data,
                'is_done' => 'T',
            ];
        } catch (\Exception $e) {
            // 例外處理，返回錯誤訊息
            $result = [
                'data' => null,
                'is_done' => 'F',
            ];
        }

        // 返回 JSON 格式的結果
        return response()->json($result);
    }

    /*
    
    {
    "orderBy": "publish_at",
    "asc": false,
    "row": 10,
    "page": 1,
    "query": "example keyword"
}
    
    */

    public function orderDetail(Request $request)
    {
        // 檢查是否有提供 id
        if (!$request->route('id')) {
            return response()->json(['error' => 'ID is required'], 400);
        }

        // 調用 OrderService 的 getDetail 方法
        $orderDetail = $this->ordersService->getDetail($request->route('id'));

        // 返回 JSON 格式的結果
        return response()->json($orderDetail);
    }

    public function inquiryList(Request $request)
    {
        // 從查詢字串獲取參數
        $params = [
            'orderBy' => $request->query('o'),
            'asc' => $request->query('a'),
            'row' => $request->query('r'),
            'page' => $request->query('p'),
            'query' => $request->query('q'),
        ];

        $result = [
            'data' => null,
            'is_done' => 'F',
        ];

        try {
            // 調用 InquiryService 的 getList 方法
            $inquiryItems = $this->inquiryService->getList($params);
             // 重新組合資料
            $data = [];
            foreach ($inquiryItems['data'] as $item) {
                $data[] = [
                    'id' => $item['id'],
                    'inquiry_from' => $item['inquiry_from'],
                    'inquiry_no' => $item['inquiry_no'],
                    'inquiry_date' => $item['inquiry_date'],
                    'customer_no' => $item['customer_no'],
                    'customer_name' => $item['customer_name'],
                    'ship_contact' => $item['ship_contact'],
                    'ship_date' => $item['ship_date'],
                    'amount' => $item['amount'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                    // 根據需求添加其他屬性
                ];
            }

            $result = [
                'data' => $data,
                'is_done' => 'T',
            ];
        } catch (\Exception $e) {
            // 例外處理，返回錯誤訊息
            $result = [
                'data' => null,
                'is_done' => 'F',
            ];
        }

        // 返回 JSON 格式的結果
        return response()->json($result);
    }

    /*
    
    {
    "orderBy": "publish_at",
    "asc": false,
    "row": 10,
    "page": 1,
    "query": "example keyword"
}
    
    */

    public function inquiryDetail(Request $request)
    {
        // 檢查是否有提供 id
        if (!$request->route('id')) {
            return response()->json(['error' => 'ID is required'], 400);
        }

        // 調用 InquiryService 的 getDetail 方法
        $inquiryDetail = $this->inquiryService->getDetail($request->route('id'));

        // 返回 JSON 格式的結果
        return response()->json($inquiryDetail);
    }

    /*
     {"id": 1
    }
    */

}
