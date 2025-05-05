<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    // 定義資料表名稱（如果資料表名稱不是 'forms'，請修改這裡）
    protected $table = 'forms'; // 根據實際資料表名稱調整

    // 允許批量賦值的欄位
    protected $fillable = [
        'form_fields', 
        'created_by', 
    ];

    // 定義資料型態轉換，特別是 JSON 和 BOOLEAN 類型的欄位
    protected $casts = [
        'form_fields' => 'json',       // 將 form_fields 轉換為 JSON 格式的陣列
    ];

    
    // 關聯設定：Form 與 User 之間的反向一對多關聯
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
