<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopeeProduct extends Model {
    use HasFactory;

    protected $fillable = [
        'shopee_product_id',
        'name',
        'data',
        'product_id'
    ];

    protected $casts = [
        'data' => 'json'
    ];
}
