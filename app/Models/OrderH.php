<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderH extends Model{
    use HasFactory;
    protected $table = 'order_h';

    protected $fillable = [
        'order_no', 'order_date', 'customer_id', 'customer_no', 'customer_name',
        'customer_tel', 'customer_address', 'ship_id', 'ship_contact', 'ship_name',
        'ship_tel', 'ship_address', 'ship_date', 'amount', 'order_from', 'id_o'
    ];
    
}

?>