<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageAudio extends Model
{
    protected $fillable = [
        'message_id', 'original_content_url'
    ];
}
