<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    // 指定資料表名稱
    protected $table = 'organizations';

    // 主鍵
    protected $primaryKey = 'id';

    // 是否自動管理時間戳記
    public $timestamps = true;

    // 可批量賦值的欄位
    protected $fillable = [
        'name',
        'description',
    ];

        // 定義資料型態轉換，特別是 JSON 和 BOOLEAN 類型的欄位
    protected $casts = [
        'teams' => 'array',           // 將 teams 轉換為 JSON 格式的陣列
    ];
}
