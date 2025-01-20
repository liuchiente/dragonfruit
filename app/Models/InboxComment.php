<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboxComment extends Model
{
    use HasFactory;

    // 定義資料表名稱 (如果資料表名稱不是預設的 'inbox_comments')
    protected $table = 'inbox_comments'; // 根據實際資料表名稱調整

    // 允許批量賦值的欄位
    protected $fillable = [
        'inbox_id',
        'comment_id',
    ];

    // 定義關聯：Inbox 和 Comment 之間的多對多關聯

    public function inbox()
    {
        return $this->belongsTo(Inbox::class, 'inbox_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}
