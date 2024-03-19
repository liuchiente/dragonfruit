<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LineAuth extends Model
{

    protected $table="line_auth";

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'line_user_id',
        'line_display_name',
        'line_status_msg',
        'line_pic_url',
        'user_id',
    ];

}
