<?php

namespace App\Models;

use App\Enums\AddressType;
use App\Enums\OrderStatus;
use App\Http\Services\Shipping\GHTKService;
use App\Traits\Common\Addressable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

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
        'sub_status'
    ];

    public function pickup_address() {
        return $this->morphOne(Address::class, 'addressable')->where('type', AddressType::PICKUP)->withTrashed();
    }

    public function inventories() {
        return $this->belongsToMany(Inventory::class, 'order_items')->withTrashed()->withPivot([
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

    public function pushShippingOrder() {
        $shipping_service = App::make(GHTKService::class);
        return $shipping_service->pushShippingOrder($this);
    }

    public function getCurrentStatusLabel() {
        switch ($this->order_status) {
            case OrderStatus::WAIT_TO_ACCEPT:
                return trans('order.order_status.wait_to_accept');
            case OrderStatus::WAITING_TO_PICK:
                return trans('order.order_status.waiting_to_pick');
            case OrderStatus::PICKING:
                return trans('order.order_status.picking');
            case OrderStatus::DELIVERING:
                return trans('order.order_status.delivering');
            case OrderStatus::DELIVERED:
                return trans('order.order_status.delivered');
            case OrderStatus::CANCELED:
                return trans('order.order_status.canceled');
            case OrderStatus::RETURN:
                return trans('order.order_status.return');
        }
    }
}
