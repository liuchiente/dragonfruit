<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    use HasFactory;

    // 指定資料表名稱
    protected $table = 'user_tokens';

    // 定義可以批量賦值的欄位
    protected $fillable = [
        'name',
        'token',
        'token_type',
        'user_id',
    ];

    // 如果資料表有時間戳欄位 (created_at, updated_at)，Laravel 預設會自動處理
    public $timestamps = true;


}
