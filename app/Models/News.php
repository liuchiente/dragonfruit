<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table="news";
    use HasFactory;

    /*
        id 
        publisher_from
        publisher
        subject
        content
        link
        link_o
        id_o
        publisher_o
        publish_at
        created_at
        updated_at
    */
}
