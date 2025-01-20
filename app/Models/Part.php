<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $table="parts";
    use HasFactory;

    /*
        id 
        part_no
        part_name
        short_name
        brand
        model
        unit
        price
        part_search
        part_ord
        is_on
        hits
        link
        link_o
        thumb
        id_o
        created_at
        updated_at
     */
}
