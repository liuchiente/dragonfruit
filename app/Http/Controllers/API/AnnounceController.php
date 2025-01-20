<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\NewsService;

class AnnounceController extends Controller
{

    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function newsList(Request $request)
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
            // 調用 NewsService 的 getList 方法
            $newsItems = $this->newsService->getList($params);
             // 重新組合資料
            $data = [];
            foreach ($newsItems['data'] as $item) {
                $data[] = [
                    'id' => $item['id'],
                    'publisher' => $item['publisher'],
                    'subject' => $item['subject'],
                    'publish_at' => $item['publish_at'],
                    'expired_at' => $item['expired_at'],
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

    public function newsDetail(Request $request)
    {
        // 檢查是否有提供 id
        if (!$request->route('id')) {
            return response()->json(['error' => 'ID is required'], 400);
        }

        // 調用 NewsService 的 getDetail 方法
        $newsDetail = $this->newsService->getDetail($request->route('id'));

        // 返回 JSON 格式的結果
        return response()->json($newsDetail);
    }

    /*
     {"id": 1
    }
    */

}
