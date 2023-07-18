<?php

namespace App\Models;

use App\Traits\Common\Imageable;
use App\Traits\Scopes\CustomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    use HasFactory, Imageable, CustomScope;

    public function getImageSizesAttribute() {
        return [
            600
        ];
    }
    const DEFAULT_IMAGE_SIZE = 600;

    protected $fillable = [
        'customer_id',
        'order_id',
        'product_score',
        'display',
        'likes',
        'customer_service_score',
        'shipping_service_score',
        'color',
        'reality',
        'material',
        'details',
        'reply',
        'reply_by',
        'customer_liked'
    ];

    protected $casts = [
        'customer_liked' => 'json'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
