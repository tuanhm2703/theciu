<?php

namespace App\Models;

use App\Http\Services\Shipping\GHTKService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ShippingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'shipping_service_id',
        'estimated_pick_time',
        'estimated_delivery_time',
        'to_address',
        'status_text',
        "code",
        'pickup_address_id',
        'shipping_service_code',
        "order_value",
        "cod_amount",
        "service_fee",
        "insurance_fee",
        "total_fee",
        'ship_at_office_hour',
        'pickup_shift_id',
    ];

    public function shipping_service() {
        return $this->belongsTo(ShippingService::class);
    }

    public function getShipServiceName() {
        return App::make(GHTKService::class)->getShipServiceNameById($this->shipping_service_code);
    }
}
