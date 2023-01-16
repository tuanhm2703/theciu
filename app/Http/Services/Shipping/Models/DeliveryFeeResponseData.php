<?php

namespace App\Http\Services\Shipping\Models;

class DeliveryFeeResponseData {
    public $total;
    public $service_fee;
    public $insurance_fee;
    public $shipping_service_id;
    public function __construct($total, $service_fee, $insurance_fee, $shipping_service_id = null) {
        $this->total = $total;
        $this->service_fee = $service_fee;
        $this->insurance_fee = $insurance_fee;
        $this->shipping_service_id = $shipping_service_id;
    }
}
