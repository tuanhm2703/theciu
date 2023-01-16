<?php

namespace App\Models;

use App\Traits\Common\Addressable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory, Addressable;

    protected $fillable = [
        'customer_id',
        'total',
        'subtotal',
        'origin_subtotal',
        'shipping_fee',
        'order_number',
        'order_status',
        'cancel_reason',
        'payment_method_id',
        'canceled_by',
    ];

    public function inventories() {
        return $this->belongsToMany(Inventory::class, 'order_items')->withPivot([
            'total',
            'quantity',
            'origin_price',
            'promotion_price',
            'title',
            'name'
        ]);
    }

    public function shipping_order() {
        return $this->hasOne(ShippingOrder::class);
    }

    public function shipping_service() {
        return $this->hasOneThrough(ShippingService::class, ShippingOrder::class, 'order_id', 'id', null, 'shipping_service_id');
    }

    public function payment_method() {
        return $this->belongsTo(PaymentMethod::class);
    }
}
