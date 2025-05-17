<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Models\Category;

class CategoryService
{
    
    private const __DEFAULT_ROWS=10;
    private const __DEFAULT_PAGE=1;
  
    public function getList(array $params, bool $assemble = false)
    {
        $orderBy = $params['orderBy'] ?? 'id';
        $asc = $params['asc'] ?? 'asc';
        $row = $params['row'] ?? null; // 允許為 null 以查詢所有資料
        $page = $params['page'] ?? null; // 允許為 null 以查詢所有資料
        $query = $params['query'] ?? '';

        // 查詢 Category
        $categoriesQuery = Category::query()
            ->where('category_name', 'like', '%' . $query . '%')
            ->orderBy($orderBy, $asc);

        // 如果 row 和 page 參數為 null，則取得所有資料
        if ($row) {
            $categories = $categoriesQuery->paginate($row, ['*'], 'page', $page)->get();
        } else {
            $categories = $categoriesQuery->get();
        }


        // 如果 assemble 為 false，返回簡單的陣列
        if (!$assemble) {
            $data= $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'id_p' => $category->id_p,
                    'category_name' => $category->category_name,
                    'search' => $category->search,
                    'category_ord' => $category->category_ord,
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at,
                ];
            })->toArray();

            return [
                'data' => $data,
                'pagination' => [
                    'total' => $categories->total(),
                    'per_page' => $categories->perPage(),
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                ],
            ];
        }

        // 如果 assemble 為 true，則建立包含子類別的結構
        return $this->assembleCategories($categories);
    }


    private function assembleCategories($categories)
{
    // 將每個 category 格式化，並建立 id map
    $categoryMap = [];
    foreach ($categories as $category) {
        $categoryMap[$category->id] = $this->formatCategory($category);
    }

    $tree = [];

    // 建構樹狀結構
    foreach ($categoryMap as $id => &$category) {
        $parentId = $category['id_p'];
        if ($parentId && isset($categoryMap[$parentId])) {
            // 加入到父節點的 sub_categories
            $categoryMap[$parentId]['sub_categories'][] = &$category;
        } else {
            // 沒有父節點，代表是根節點
            $tree[] = &$category;
        }
    }

    return $tree;
}

    

    private function formatCategory($category)
    {
        return [
            'id' => $category->id,
            'id_p' => $category->id_p,
            'category_name' => $category->category_name,
            'search' => $category->search,
            'category_ord' => $category->category_ord,
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
            'sub_categories' => [],
        ];
    }


}