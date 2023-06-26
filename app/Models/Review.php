<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'inventory_id',
        'product_score',
        'display',
        'customer_service_score',
        'shipping_service_score',
        'color',
        'reality',
        'material',
        'details',
    ];
}
