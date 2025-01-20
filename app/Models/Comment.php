<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // 定義資料表名稱 (如果資料表名稱不是預設的 'comments')
    protected $table = 'comments'; // 根據你的資料表名稱調整

    // 允許批量賦值的欄位
    protected $fillable = [
        'message',
        'user_id',
        'like',
        'type',
        'action',
        'inbox_id',
    ];

    // 如果 like 欄位是 JSON 或 array 資料格式，這裡設置它的 cast
    protected $casts = [
        'like' => 'array', // 這會將 like 欄位轉換為 PHP array
    ];

    // 定義關聯 (如果有必要)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // 假設 Comment 和 User 之間有一對多的關聯
    }

    // 這裡可以根據需要定義其他關聯
    public function inbox()
    {
        return $this->belongsTo(Inbox::class, 'inbox_id'); // 假設 Comment 和 Inbox 之間有一對多的關聯
    }
}
