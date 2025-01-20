<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\FlexMessage;

use App\Models\Inquiryh;
use App\Models\Inquiryd;
use App\Models\Inquiryp;

class InquiryService
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

        // 查詢 Inquiryh
        $inquiryQuery = Inquiryh::where('customer_id', $filters['customer_id']);

        // 應用額外的過濾條件
        foreach ($filters as $key => $value) {
            if ($key !== 'customer_id') {
                $inquiryQuery->where($key, $value);
            }
        }

        // 應用查詢字符串
        if (!empty($query)) {
            $inquiryQuery->where(function ($q) use ($query) {
                $q->where('inquiry_no', 'like', '%' . $query . '%')
                  ->orWhere('customer_name', 'like', '%' . $query . '%')
                  ->orWhere('ship_contact', 'like', '%' . $query . '%');
            });
        }

        // 排序和分頁
        $inquiries = $inquiryQuery->orderBy($orderBy, $asc)
            ->paginate($row, ['*'], 'page', $page);

        $inquiries=collect($inquiries);

        // 轉換結果為陣列
        return $inquiries->items()->map(function ($inquiry) {
            return [
                'id' => $inquiry->id,
                'inquiry_from' => $inquiry->inquiry_from,
                'inquiry_no' => $inquiry->inquiry_no,
                'inquiry_date' => $inquiry->inquiry_date,
                'customer_id' => $inquiry->customer_id,
                'customer_no' => $inquiry->customer_no,
                'customer_name' => $inquiry->customer_name,
                'ship_id' => $inquiry->ship_id,
                'ship_contact' => $inquiry->ship_contact,
                'ship_date' => $inquiry->ship_date,
                'amount' => $inquiry->amount,
                'created_at' => $inquiry->created_at,
                'updated_at' => $inquiry->updated_at,
            ];
        })->toArray();
    }

    public function getDetail(int $id)
    {
        // 取得 Inquiryh 的詳細資料
        $inquiryh = Inquiryh::find($id);

        // 如果找不到該筆詢問，返回 null 或拋出例外
        if (!$inquiryh) {
            return null; // 或者拋出例外，例如 throw new \Exception("Inquiry not found");
        }

        // 取得與 Inquiryh 相關的多筆 Inquiryd
        $inquiryDetails = Inquiryd::where('inquiry_h_id', $id)->get();

        // 組合詢問詳細資料
        $inquiryItems = $inquiryDetails->map(function ($detail) {
            return [
                'id' => $detail->id,
                'inquiry_h_id' => $detail->inquiry_h_id,
                'part_id' => $detail->part_id,
                'part_no' => $detail->part_no,
                'part_name' => $detail->part_name,
                'part_price' => $detail->part_price,
                'part_count' => $detail->part_count,
                'sub_total' => $detail->sub_total,
                'created_at' => $detail->created_at,
                'updated_at' => $detail->updated_at,
            ];
        });

        // 組合完整的詢問詳細資料
        $result = [
            'inquiry' => [
                'id' => $inquiryh->id,
                'inquiry_from' => $inquiryh->inquiry_from,
                'inquiry_no' => $inquiryh->inquiry_no,
                'inquiry_date' => $inquiryh->inquiry_date,
                'customer_id' => $inquiryh->customer_id,
                'customer_no' => $inquiryh->customer_no,
                'customer_name' => $inquiryh->customer_name,
                'customer_tel' => $inquiryh->customer_tel,
                'customer_address' => $inquiryh->customer_address,
                'ship_id' => $inquiryh->ship_id,
                'ship_contact' => $inquiryh->ship_contact,
                'ship_name' => $inquiryh->ship_name,
                'ship_tel' => $inquiryh->ship_tel,
                'ship_address' => $inquiryh->ship_address,
                'ship_date' => $inquiryh->ship_date,
                'amount' => $inquiryh->amount,
                'id_o' => $inquiryh->id_o,
                'created_at' => $inquiryh->created_at,
                'updated_at' => $inquiryh->updated_at,
            ],
            'inquiry_items' => $inquiryItems,
        ];

        return $result;
    }
}