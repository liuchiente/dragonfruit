<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // 定義資料表名稱（如果資料表名稱不是 'tasks'，請修改這裡）
    protected $table = 'tasks'; // 根據實際資料表名稱調整

    // 允許批量賦值的欄位
    protected $fillable = [
        'description', 
        'due_date', 
        'is_reminder', 
        'assignees', 
        'organization_id', 
        'created_by', 
        'team', 
        'priority_level', 
        'status'
    ];

    // 定義資料型態轉換，特別是 JSON 和 BOOLEAN 類型的欄位
    protected $casts = [
        'is_reminder' => 'boolean',       // 將 is_reminder 轉換為布林值
        'assignees' => 'array',           // 將 assignees 轉換為 JSON 格式的陣列
        'due_date' => 'string',           // 假設 due_date 是字串型別
        'priority_level' => 'string',     // 優先級是字串
        'status' => 'string',             // 狀態是字串
    ];

    // 設定預設值（Laravel 的 default 值通常在資料庫遷移中設定）
    protected $attributes = [
        'is_reminder' => false,           // 預設值是 false
        'priority_level' => 'Low',        // 預設優先級是 'Low'
        'status' => 'todo',               // 預設狀態是 'todo'
    ];

    // 關聯設定：Task 與 User 之間的反向一對多關聯
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Task 和 Organization 之間的反向一對多關聯
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    // Task 和 Assignees 之間的多對多關聯（假設 assignees 是一個 JSON 格式的多個用戶）
    public function assignees()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }
}
