<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboxUser extends Model
{
    use HasFactory;

    // 定義資料表名稱 (如果資料表名稱不是預設的 'inbox_comments')
    protected $table = 'inbox_user'; // 根據實際資料表名稱調整

    // 允許批量賦值的欄位
    protected $fillable = [
        'inbox_id',
        'user_id',
    ];

    // 定義關聯：Inbox 和 User 之間的多對多關聯

    public function inbox()
    {
        return $this->belongsTo(Inbox::class, 'inbox_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
