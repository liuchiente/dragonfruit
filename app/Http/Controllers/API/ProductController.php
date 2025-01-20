<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\PartsService;
use App\Services\CategoryService;

class ProductController extends Controller
{

    protected $partsService;
    protected $categoryService;

    public function __construct(PartsService $partsService,CategoryService $categoryService)
    {
        $this->partsService = $partsService;
        $this->categoryService = $categoryService;
    }

    public function partList(Request $request)
    {
        // 從查詢字串獲取參數
        $params = [
            'orderBy' => $request->query('o'),
            'asc' => $request->query('a'),
            'row' => $request->query('r'),
            'page' => $request->query('p'),
            'query' => $request->query('q'),
        ];

        $filter = [
            'categories.id' => $request->query('c'),
        ];

        $result = [
            'data' => null,
            'is_done' => 'F',
        ];

        try {
            $partsItems = $this->partsService->getList($params,$filter);
             // 重新組合資料
            $data = [];
            foreach ($partsItems['data'] as $item) {
                $data[] = [
                    'id' => $item['id'],
                    'part_no' => $item['part_no'],
                    'part_name' => $item['part_name'],
                    'part_price' => $item['part_price'],
                    'thumb' => $item['thumb'],
                    'brand' => $item['brand'],
                    'model' => $item['model'],
                    'category_id' => $item['category_id'],
                    'category_name' => $item['category_name'],
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


    public function partDetail(Request $request)
    {

        // 檢查是否有提供 id
        if (!$request->route('id')) {
            return response()->json(['error' => 'ID is required'], 400);
        }

        // 調用 PartsService 的 getDetail 方法
        $partDetail = $this->partsService->getDetail($request->route('id'));

        // 如果找到資料，返回 JSON 格式的結果
        if ($partDetail) {
            return response()->json($partDetail);
        } else {
            return response()->json(['error' => 'Part not found'], 404);
        }
    }

    public function categoriesList(Request $request)
    {
        /*$json_str='{
           "is_done":true,
           "payload":[
              {
                 "featured":true,
                 "icon_url":"assets/icons/Discount.svg",
                 "name":"MS電磁開關"
              },
              {
                 "featured":false,
                 "icon_url":"assets/icons/High-heels.svg",
                 "name":"樓宇自動化控制"
              },
              {
                 "featured":false,
                 "icon_url":"assets/icons/Woman-dress.svg",
                 "name":"機電產品"
              },
              {
                 "featured":false,
                 "icon_url":"assets/icons/Man-Clothes.svg",
                 "name":"手工具"
              },
              {
                 "featured":false,
                 "icon_url":"assets/icons/Man-Pants.svg",
                 "name":"感測器"
              },
              {
                 "featured":false,
                 "icon_url":"assets/icons/Man-Shoes.svg",
                 "name":"接線盒"
              }
           ]
        }';*/
       
        $assemble = $request->query('s')==true ?? false;

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

    
       // try {
            
            // 呼叫 CategoryService 的 getList 方法
            $categories = $this->categoryService->getList($params, $assemble);

            // 重新組合每個類別
            /*$data = [];
            foreach ($categories as $category) {
                $data[] = [
                    'id' => $category['id'],
                    'id_p' => $category['id_p'],
                    'category_name' => $category['category_name'],
                    'search' => $category['search'],
                    'category_ord' => $category['category_ord'],
                    'created_at' => $category['created_at'],
                    'updated_at' => $category['updated_at'],
                    'sub_categories' => $category['sub_categories'] ?? [],
                ];
            }*/

            $result = [
                'data' =>  $categories,
                'is_done' => 'T',
            ];
        //} catch (\Exception $e) {
            // 例外處理，返回錯誤訊息
            $result = [
                'data' => null,
                'is_done' => 'F',
            ];
        //}


        // 轉換成 JSON 並返回
        return response()->json($result);
    }
}
