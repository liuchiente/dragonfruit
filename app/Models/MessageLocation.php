<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageLocation extends Model
{
    protected $fillable = [
        'message_id', 'title', 'address', 'latitude', 'longitude'
    ];
}
