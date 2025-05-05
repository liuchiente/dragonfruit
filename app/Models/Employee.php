<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $table="user_employee";

    use HasFactory;

    protected $fillable = [
        'emp_account',
        'emp_no',
        'emp_id',
        'user_profile_id',
        'emp_password',
        'emp_name',
        'user_id',
        'email',
        'identity',
        'IDRep',
        'leave_day',
        'login_time',
        'login_key'
    ];

      // 設置與 User 的關聯
      public function user()
      {
          return $this->belongsTo(User::class);
      }
}

