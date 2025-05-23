<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'cart_id',
        'city',
        'shipping_address',
        'payment_method',
        'total_amount',
        'status',
        'created_at',
        'updated_at',
    ];
    public $timestamps = true;
}


