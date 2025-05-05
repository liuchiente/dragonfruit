<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class InboxNotification extends Model
{
    use HasFactory;

    // 定義資料表名稱 (如果資料表名稱不是預設的 'inboxes')
    protected $table = 'inbox_notifications'; // 根據實際資料表名稱調整

    // 允許批量賦值的欄位
    protected $fillable = [
        'inbox_id',
        'title',
        'message',
        'user_ids',
        'tokens',
        'sent_at',
        'send_at'
    ];

    // 定義資料型態轉換，尤其是 JSON 格式的欄位 (如 'like')
    protected $casts = [
        'like' => 'array', // 將 'like' 欄位轉為 PHP array (假設 'like' 儲存為 JSON)
        'sent_at' => 'datetime', // 確保 'sent_date' 被正確解析為 Carbon 的日期格式
        'send_at' => 'datetime', // 確保 'sent_date' 被正確解析為 Carbon 的日期格式
        'user_ids' => 'array',
        'tokens' => 'array'
    ];

    // 如果需要定義關聯，可以在這裡設置
    public function inbox()
    {
        return $this->belongsTo(Inbox::class, 'inbox_id');
    }


}
