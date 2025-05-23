<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

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
}
