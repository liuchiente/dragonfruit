<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageText extends Model
{
    protected $fillable = [
        'message_id', 'text'
    ];
}
