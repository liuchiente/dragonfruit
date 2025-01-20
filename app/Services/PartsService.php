<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Models\Part;
use App\Models\CategoryPart;
use App\Models\Category;
use App\Models\PartsAttachment;
use App\Models\Attachment;

class PartsService
{
    
    private const __DEFAULT_ROWS=10;
    private const __DEFAULT_PAGE=1;
  
    /**
     * 產品清單
     */
    /*public function getList($opt=[],$param=[]){
        //初始化條件
        $opt['order']=isset($opt['order'])?$opt['order']:"id";
        $opt['asc']=isset($opt['asc'])?$opt['asc']:"desc";
        $opt['row']=(int)(isset($opt['row'])?$opt['row']:self::__DEFAULT_ROWS);
        $opt['page']=(int)(isset($opt['page'])?$opt['page']:self::__DEFAULT_PAGE);
        $opt['query']=isset($opt['query'])?$opt['query']:"";

        $offset=$opt['page']*$opt['row'];

        $fields=[
          'id',
          'part_no',
          'part_name',
          'brand',
          'unit',
          'link'
        ];

        $param=[['is_on','=',1]];
        $partList=Part::select($fields)->where($param)->offset($offset)->limit($opt['page'])->orderBy($opt['orderBy'],$opt['asc'])->get();
        return $partList;
    }*/

    public function getList(array $params, array $filter = [])
    {
       // 預設 filter
       $filters = array_merge(['is_on' => 1], $filter);
       //\DB::enableQueryLog(); // Enable query log
       // 查詢 Part
       $query = Part::query()
           ->leftjoin('category_parts', 'parts.id', '=', 'category_parts.part_id')
           ->leftjoin('categories', 'category_parts.category_id', '=', 'categories.id')
           ->select(
               'parts.id',
               'parts.part_no',
               'parts.part_name',
               'parts.thumb',
               'parts.brand',
               'parts.model',
               'parts.unit',
               'parts.part_price',
               'parts.is_on',
               'parts.link_o',
               'parts.created_at',
               'parts.updated_at',
               'category_parts.category_id',
               'categories.category_name'
           )
           ->where('parts.is_on', $filters['is_on']);

       // 動態過濾條件
       foreach ($filters as $key => $value) {
           if ($key !== 'is_on' && $value != null) {
               $query->where($key, $value);
           }
       }

       // 排序與分頁
       $orderBy = $params['orderBy'] ?? 'created_at';
       $asc = $params['asc'] ?? 'asc';
       $row = $params['row'] ?? self::__DEFAULT_ROWS;
       $page = $params['page'] ?? self::__DEFAULT_PAGE;

       // 取得 Part 資料
       $parts = $query->orderBy($orderBy, $asc)
           ->paginate($row, ['*'], 'page', $page);

       // 將 Part 資料轉換為陣列
       $partsArray = $parts->toArray()['data'];

       //dd(\DB::getQueryLog()); // Show results of log
       // 組合結果並返回
       return [
           'data' => $partsArray,
           'current_page' => $parts->currentPage(),
           'last_page' => $parts->lastPage(),
           'per_page' => $parts->perPage(),
           'total' => $parts->total(),
       ];
    }

    /**
     * 產品細節
     */
    public function getDetail($id)
    {
        // 使用 ID 查找指定的零件資料
        $part = Part::find($id);

        // 如果找不到，返回 null 或拋出異常
        if (!$part) {
            return null; // 或可以選擇拋出異常，例如: throw new \Exception('Part not found');
        }

        // 為Part 加入 attachments
        $part['attachments'] = PartsAttachment::where('part_id', $part['id'])
                ->pluck('attachment_id');

        // 取得附件資料
        $part['attachments'] = Attachment::whereIn('id', $part['attachments'])
            ->select('id', 'name', 'description', 'mime', 'type', 'link', 'created_at', 'updated_at')
            ->get()
            ->toArray();

        // 為Part 加入 Categories
        $part['categories'] = CategoryPart::where('part_id', $part['id'])
        ->pluck('category_id');

        // 取得類別資料
        $part['categories'] = Category::whereIn('id', $part['categories'])
            ->select('id', 'category_no', 'category_name')
            ->get()
            ->toArray();

        // 將查詢結果轉換為陣列並返回
        return $part->toArray();
    }


}