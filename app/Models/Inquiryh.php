<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiryh extends Model
{
    protected $table="inquiry_h";
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

    public function inquiryds(): HasMany
    {
        return $this->hasMany(Inquiryd::class);
    }
    
}
