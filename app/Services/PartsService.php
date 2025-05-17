<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Models\Part;
use Illuminate\Pagination\LengthAwarePaginator;

class PartsService
{
    
    private const __DEFAULT_ROWS=10;
    private const __DEFAULT_PAGE=1;
  
   /**
     * 根據選項和過濾條件來獲取產品列表
     *
     * @param array $opt 分頁選項，包括頁數、每頁數量和排序欄位
     * @param array $filter 產品過濾條件，包括關鍵字和產品類別
     * @return LengthAwarePaginator
     */
    public function getList(array $opt, array $filter)
    {
        // 取得分頁設定
        $page = $opt['page'] ?? self::__DEFAULT_PAGE;
        $perPage = $opt['perPage'] ?? self::__DEFAULT_ROWS;
        $sortBy = $opt['sortBy'] ?? 'created_at';
        $sortOrder = $opt['sortOrder'] ?? 'desc';

        // 開始查詢
        $query = Part::query();

        // 過濾條件: 關鍵字搜尋
        if (!empty($filter['keyword'])) {
            $query->where(function (Builder $q) use ($filter) {
                $q->where('part_name', 'like', '%' . $filter['keyword'] . '%')
                  ->orWhere('part_search', 'like', '%' . $filter['keyword'] . '%');
            });
        }

        // 過濾條件: 產品類別
        if (!empty($filter['category_id'])) {
            $query->whereHas('categories', function (Builder $q) use ($filter) {
                $q->where('category_id', $filter['category_id']);
            });
        }

        // 排序
        $query->orderBy($sortBy, $sortOrder);

        // 分頁處理
        $partsItems= $query->paginate($perPage, ['*'], 'page', $page);

        $data = array_map(function ($item) {
            return [
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
            }, $partsItems->items());

         return [
                'data' => $data,
                'pagination' => [
                    'total' => $partsItems->total(),
                    'per_page' => $partsItems->perPage(),
                    'current_page' => $partsItems->currentPage(),
                    'last_page' => $partsItems->lastPage(),
                ],
            ];
            
        }

    /**
     * 產品細節
     */
    public function getDetail(int $id)
    {
        return Part::with('attachments')->find($id);
    }

}