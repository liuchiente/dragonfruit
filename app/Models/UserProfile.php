<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    // 指定資料表名稱
    protected $table = 'user_profiles';

    // 定義可以批量賦值的欄位
    protected $fillable = [
        'name',
        'picture',
        'organization_id',
        'team',
        'email',
        'phone_number',
        'user_id',
        'uid',
    ];

     // 設置與 User 的關聯
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 如果資料表有時間戳欄位 (created_at, updated_at)，Laravel 預設會自動處理
    public $timestamps = true;

}
