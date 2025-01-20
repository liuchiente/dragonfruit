<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // 定義資料表名稱（如果資料表名稱不是 'users'，請修改這裡）
    protected $table = 'users'; // 根據實際資料表名稱調整

    // 允許批量賦值的欄位
    protected $fillable = [
        'name', 
        'picture', 
        'organization_id', 
        'team', 
        'fcm_token', 
        'auth_token', 
        'email', 
        'phone_number', 
        'user_id', 
        'sign_in_provider'
    ];

    // 定義資料型態轉換，特別是 TEXT 類型的欄位
    protected $casts = [
        'fcm_token' => 'string',
        'auth_token' => 'string',
        'email' => 'string',
        'phone_number' => 'string',
        'user_id' => 'string',
        'sign_in_provider' => 'string',
    ];

    // 關聯設定：User 和 Organization 之間的反向一對多關聯
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    // 如果有其他與 User 關聯的模型，可以在這裡添加方法
    // 例如：User 和 Task 之間的一對多關聯
    public function tasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    // 例如：User 和 Inbox 之間的一對多關聯
    public function inboxes()
    {
        return $this->hasMany(Inbox::class, 'user_id');
    }

    // 例如：User 和 Comment 之間的一對多關聯
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
}
