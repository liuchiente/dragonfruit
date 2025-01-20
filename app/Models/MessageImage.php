<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageImage extends Model
{
    protected $fillable = [
        'message_id', 'image_set_id', 'original_content_url'
    ];
}
