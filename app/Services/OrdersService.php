<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\FlexMessage;

use App\Models\LineMember;
use App\Models\LineGroup;
use App\Models\LineChat;

class OrdersService
{
    
    private const __DEFAULT_ROWS=10;
    private const __DEFAULT_PAGE=1;
  
    public function getList(array $opt = [], array $filter = [])
    {
        $page = $opt['page'] ?? self::__DEFAULT_PAGE;
        $row = $opt['row'] ?? self::__DEFAULT_ROWS;
        $orderBy = $opt['orderBy'] ?? 'id';
        $direction = $opt['direction'] ?? 'desc';

        $query = Order::query()
            ->when(!empty($filter['keyword']), function ($q) use ($filter) {
                $keyword = $filter['keyword'];
                $q->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('order_no', 'like', "%{$keyword}%")
                             ->orWhere('customer_name', 'like', "%{$keyword}%")
                             ->orWhere('ship_name', 'like', "%{$keyword}%");
                });
            })
            ->orderBy($orderBy, $direction);

        $orders = $query->paginate($row, ['*'], 'page', $page);

        $data = $orders->getCollection()->map(function ($item) {
            return [
                'order_no' => $item->order_no,
                'order_date' => $item->order_date,
                'customer_name' => $item->customer_name,
                'ship_contact' => $item->ship_contact,
                'ship_name' => $item->ship_name,
                'ship_tel' => $item->ship_tel,
                'ship_date' => $item->ship_date,
            ];
        })->toArray();

        return [
            'data' => $data,
            'pagination' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
            ]
        ];
    }
    /**
     * 訂單細節
     */
    public function getDetail($id){
      return News::find($id);
    }
}