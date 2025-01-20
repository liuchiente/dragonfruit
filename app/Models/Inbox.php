<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    use HasFactory;

    // 定義資料表名稱 (如果資料表名稱不是預設的 'inboxes')
    protected $table = 'inboxes'; // 根據實際資料表名稱調整

    // 允許批量賦值的欄位
    protected $fillable = [
        'title',
        'message',
        'user_id',
        'due_date',
        'status',
        'team',
        'like',
        'type',
        'action',
    ];

    // 定義資料型態轉換，尤其是 JSON 格式的欄位 (如 'like')
    protected $casts = [
        'like' => 'array', // 將 'like' 欄位轉為 PHP array (假設 'like' 儲存為 JSON)
        'due_date' => 'datetime', // 確保 'due_date' 被正確解析為 Carbon 的日期格式
    ];

    // 如果需要定義關聯，可以在這裡設置
    // 假設 'user_id' 外鍵指向 'users' 表，並且 'inbox' 和 'user' 存在一對多關聯
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 這裡可以根據需要定義其他關聯
    // 如果有其他模型需要與 'Inbox' 進行關聯，則可以在這裡設置
    public function comments()
    {
       return $this->hasMany(Comment::class);
    }
}
