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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ordered_items()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'order_id', 'id');
    }
}





