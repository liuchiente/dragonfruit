<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineMessageLog extends Model
{
    protected $fillable = [
        'webhook_event_id', 'type', 'timestamp', 'source_type', 'group_id', 'user_id', 'message_type'
    ];
}
