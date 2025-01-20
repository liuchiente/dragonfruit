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
            return $categories->map(function ($category) {
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
        }

        // 如果 assemble 為 true，則建立包含子類別的結構
        return $this->assembleCategories($categories);
    }


    private function assembleCategories($categories,$categoriesArray = [])
    {
        $categoriesMap = $categories->keyBy('id');

        foreach ($categories as $category) {
            // 將最上層的類別加入主陣列
            if ($category->id_p == 0) {
                $categoriesArray[$category->id] = $this->formatCategory($category);
            } 
        }

        return array_values($categoriesArray);
    }

private function addCategoryToParent(&$categoriesArray, $category)
{
    $parentId = $category->id_p;

    // 如果父類別存在，則將類別添加到其子類別中
    if (isset($categoriesArray[$parentId])) {
        // 初始化子類別陣列（如果尚未存在）
        if (!isset($categoriesArray[$parentId]['sub_categories'])) {
            $categoriesArray[$parentId]['sub_categories'] = [];
        }
        // 將當前類別添加到父類別的子類別陣列中
        $categoriesArray[$parentId]['sub_categories'][] = $this->formatCategory($category);
    }

    // 遞迴尋找父類別以支持 N 層結構
    if (isset($categoriesArray[$parentId])) {
        $this->addCategoryToParent($categoriesArray, $categoriesArray[$parentId]);
    }
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