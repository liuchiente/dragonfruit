<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderh extends Model
{
    protected $table="order_h";
    use HasFactory;

    /*
    id
    order_no
    order_date
    customer_name
    customer_tel
    customer_address
    ship_name
    ship_tel
    ship_address
    ship_date
    amount
    order_from
    id_o
    created_at
    updated_at
    */
    
    public function orderds(): HasMany
    {
        return $this->hasMany(Orderd::class);
    }

    public function orderps(): HasMany
    {
        return $this->hasMany(Orderp::class);
    }
}
