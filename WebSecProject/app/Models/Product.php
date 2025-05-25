<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'price',
        'stock',
        'model',
        'description',
        'seller_id',
        'image',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
     }
// <<<<<<< HEAD
    
//     public function cartItems()
//     {
//         return $this->hasMany(CartItem::class);
//     }

//     public function orderItems()
//     {
//         return $this->hasMany(OrderItem::class);
//     }
// }
// =======

//     public function orderItems()
//     {
//         return $this->hasMany(\App\Models\OrderItem::class, 'product_id', 'id');
//     }
// }
// >>>>>>> c852b8fff83275450059bb2eb3aa357423d9959
    }