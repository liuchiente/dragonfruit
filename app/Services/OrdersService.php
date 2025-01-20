<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\FlexMessage;

use App\Models\Orderh;
use App\Models\Orderd;
use App\Models\Orderp;

class OrdersService
{
    
    private const __DEFAULT_ROWS=10;
    private const __DEFAULT_PAGE=1;
  
    /**
     * 訂單清單
     */
    /*public function getList($opt=[]){
        //初始化條件
        $opt['orderBy']=isset($opt['orderBy'])?$opt['orderBy']:"id";
        $opt['asc']=isset($opt['asc'])?$opt['asc']:"desc";
        $opt['row']=(int)(isset($opt['row'])?$opt['row']:self::__DEFAULT_ROWS);
        $opt['page']=(int)(isset($opt['page'])?$opt['page']:self::__DEFAULT_PAGE);

        $offset=$opt['page']*$opt['row'];

        //主題、內容、發佈人、超連結
        $newsList=News::select('id','suject','content','publisher','link_o')->offset($offset)->limit($opt['page'])->orderBy($opt['orderBy'],$opt['asc'])->get();
        return $newsList;
    }*/


    public function getList(array $params, array $filters = ['customer_id' => 0])
    {
        // 提取參數
        $orderBy = $params['orderBy'] ?? 'id';
        $asc = $params['asc'] ?? 'asc';
        $row = $params['row'] ?? 10;
        $page = $params['page'] ?? 1;
        $query = $params['query'] ?? '';

        // 查詢 Orderh
        $orderQuery = Orderh::where('customer_id', $filters['customer_id']);

        // 應用額外的過濾條件
        foreach ($filters as $key => $value) {
            if ($key !== 'customer_id') {
                $orderQuery->where($key, $value);
            }
        }

        // 應用查詢字符串
        if (!empty($query)) {
            $orderQuery->where(function ($q) use ($query) {
                $q->where('order_no', 'like', '%' . $query . '%')
                  ->orWhere('customer_name', 'like', '%' . $query . '%')
                  ->orWhere('ship_contact', 'like', '%' . $query . '%');
            });
        }

        // 排序和分頁
        $orders = $orderQuery->orderBy($orderBy, $asc)
            ->paginate($row, ['*'], 'page', $page);

        $orders=collect($orders);

        // 轉換結果為陣列
        return $orders->items()->map(function ($order) {
            return [
                'id' => $order->id,
                'inquiry_from' => $order->inquiry_from,
                'inquiry_no' => $order->inquiry_no,
                'inquiry_date' => $order->inquiry_date,
                'customer_id' => $order->customer_id,
                'customer_no' => $order->customer_no,
                'customer_name' => $order->customer_name,
                'ship_id' => $order->ship_id,
                'ship_contact' => $order->ship_contact,
                'ship_date' => $order->ship_date,
                'amount' => $order->amount,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ];
        })->toArray();
    }


    /**
     * 訂單細節
     */
    public function getDetail(int $id)
    {
        // 取得 Orderh 的詳細資料
        $orderh = Orderh::find($id);

        // 如果找不到該筆訂單，返回 null 或拋出例外
        if (!$orderh) {
            return null; // 或者抛出一个异常，例如 throw new \Exception("Order not found");
        }

        // 取得與 Orderh 相關的多筆 Orderd
        $orderDetails = Orderd::where('order_h_id', $id)->get();

        // 組合訂單詳細資料
        $orderItems = [];
        foreach ($orderDetails as $detail) {
            // 取得與 Orderd 相關的 Orderp
            $orderParts = Orderp::where('order_h_id', $id)
                ->where('part_id', $detail->part_id)
                ->get();

            // 將 Orderp 資料組合到 orderItems 中
            $orderItems[] = [
                'order_detail' => [
                    'id' => $detail->id,
                    'order_h_id' => $detail->order_h_id,
                    'part_id' => $detail->part_id,
                    'part_no' => $detail->part_no,
                    'part_name' => $detail->part_name,
                    'part_price' => $detail->part_price,
                    'part_count' => $detail->part_count,
                    'sub_total' => $detail->sub_total,
                    'created_at' => $detail->created_at,
                    'updated_at' => $detail->updated_at,
                ],
                'order_parts' => $orderParts->map(function ($part) {
                    return [
                        'id' => $part->id,
                        'order_h_id' => $part->order_h_id,
                        'part_id' => $part->part_id,
                        'payment_no' => $part->payment_no,
                        'payment_name' => $part->payment_name,
                        'payment_amt' => $part->payment_amt,
                        'created_at' => $part->created_at,
                        'updated_at' => $part->updated_at,
                    ];
                })->toArray(),
            ];
        }

        // 組合完整的訂單詳細資料
        $result = [
            'order' => [
                'id' => $orderh->id,
                'order_from' => $orderh->order_from,
                'order_no' => $orderh->order_no,
                'order_date' => $orderh->order_date,
                'customer_id' => $orderh->customer_id,
                'customer_no' => $orderh->customer_no,
                'customer_name' => $orderh->customer_name,
                'customer_tel' => $orderh->customer_tel,
                'customer_address' => $orderh->customer_address,
                'ship_id' => $orderh->ship_id,
                'ship_contact' => $orderh->ship_contact,
                'ship_name' => $orderh->ship_name,
                'ship_tel' => $orderh->ship_tel,
                'ship_address' => $orderh->ship_address,
                'ship_date' => $orderh->ship_date,
                'amount' => $orderh->amount,
                'id_o' => $orderh->id_o,
                'created_at' => $orderh->created_at,
                'updated_at' => $orderh->updated_at,
            ],
            'order_items' => $orderItems,
        ];

        return $result;
    }
}