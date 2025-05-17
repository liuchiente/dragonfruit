<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Models\News;



class NewsService
{
    
    private const __DEFAULT_ROWS=10;
    private const __DEFAULT_PAGE=1;
  
    /**
     * 公告清單
     */
     public function getList(array $opt = [], array $filter = [])
    {
        $page = $opt['page'] ?? 1;
        $row = $opt['row'] ?? 10;
        $orderBy = $opt['orderBy'] ?? 'id';
        $direction = $opt['direction'] ?? 'desc';

        $query = News::query()
            ->when(!empty($filter['keyword']), function ($q) use ($filter) {
                $keyword = $filter['keyword'];
                $q->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('subject', 'like', '%' . $keyword . '%')
                             ->orWhere('publisher', 'like', '%' . $keyword . '%')
                             ->orWhere('content', 'like', '%' . $keyword . '%');
                });
            })
            ->orderBy($orderBy, $direction);

        $newsItems=$query->paginate($row, ['*'], 'page', $page);
        $data = array_map(function ($item) {
            return [
                'id' => $item['id'],
                'publisher' => $item['publisher'],
                'subject' => $item['subject'],
                'publish_at' => $item['publish_at'],
                'expired_at' => $item['expired_at'],
                // 根據需求添加其他屬性
            ];
        }, $newsItems->items());

        return [
            'data' => $data,
            'pagination' => [
                'total' => $newsItems->total(),
                'per_page' => $newsItems->perPage(),
                'current_page' => $newsItems->currentPage(),
                'last_page' => $newsItems->lastPage(),
            ],
        ];
    }

    /**
     * 公告細節
     */
    public function getDetail(int $id)
    {
        return News::with('attachments')->find($id);
    }

}