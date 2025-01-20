<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\Models\News;
use App\Models\NewsAttachment;
use App\Models\Attachment;


class NewsService
{
    
    private const __DEFAULT_ROWS=10;
    private const __DEFAULT_PAGE=1;
  
    /**
     * 公告清單
     */
    public function getList(array $params, array $filter = [])
    {
       // 預設 filter
       $currentDateTime = Carbon::now();
       $filters = array_merge( $filter, ['publish_at' => $currentDateTime, 'expired_at' => $currentDateTime]);
       
       // 查詢 News
       $query = News::query()
           ->select(
               'publisher_from',
               'publisher',
               'subject',
               'content',
               'content_rich',
               'link_o',
               'publisher_o',
               'publish_at',
               'expired_at',
               'id'
           )->where('publish_at', '<=', $filters['publish_at'])
           ->where('expired_at', '>=', $filters['expired_at']);

       // 動態過濾條件
       foreach ($filters as $key => $value) {
           if ($key !== 'publish_at' && $key !== 'expired_at') {
               $query->where($key, $value);
           }
       }

       // 排序與分頁
       $orderBy = $params['orderBy'] ?? 'publish_at';
       $asc = $params['asc'] ?? 'asc';
       $row = $params['row'] ?? 10;
       $page = $params['page'] ?? 1;

       
       // 取得 News 資料
       $news = $query->orderBy($orderBy, $asc)
           ->paginate($row, ['*'], 'page', $page);

       // 將 News 資料轉換為陣列
       $newsArray = $news->toArray()['data'];

       // 為每個 News 加入 attachments
       foreach ($newsArray as &$item) {
           $attachmentIds = NewsAttachment::where('news_id', $item['id'])
               ->pluck('attachment_id');

           // 取得附件資料
           $item['attachments'] = Attachment::whereIn('id', $attachmentIds)
               ->select('id', 'name', 'description', 'mime', 'type', 'link', 'created_at', 'updated_at')
               ->get()
               ->toArray();
       }

       // 組合結果並返回
       return [
           'data' => $newsArray,
           'current_page' => $news->currentPage(),
           'last_page' => $news->lastPage(),
           'per_page' => $news->perPage(),
           'total' => $news->total(),
       ];
    }

    /**
     * 公告細節
     */
    public function getDetail($id)
    {
        // 查詢單筆資料
        $news = News::find($id);

        // 如果找不到該筆資料，拋出例外
        if (!$news) {
            throw new ModelNotFoundException('News not found.');
        }

        // 將查詢結果轉換成陣列並回傳
        return $news->toArray();
    }

}