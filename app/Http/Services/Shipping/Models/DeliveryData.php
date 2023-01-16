<?php

namespace App\Http\Services\Shipping\Models;

use App\Models\Address;

class DeliveryData {
    public $shipping_address;
    public $service_id;
    public $service_type_id;
    public $weight;
    public $length;
    public $width;
    public $height;
    public $total_value;
    public $shipping_service_id;
    public $ship_at_office_hour;
    public $estimated_delivery_time;

    public function __construct1(Address $shipping_address, string $service_id, string $service_type_id, float $total_value,
    int $weight, int $length = null, int $width = null, int $height = null) {
        $this->shipping_address = $shipping_address;
        $this->service_id = $service_id;
        $this->service_type_id = $service_type_id;
        $this->weight = $weight;
        $this->total_value = $total_value;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
    }
    public function __construct() {
        $get_arguments       = func_get_args();
        $number_of_arguments = func_num_args();
        if($number_of_arguments >= 5) {
            if (method_exists($this, $method_name = '__construct1')) {
                call_user_func_array(array($this, $method_name), $get_arguments);
            }
        }
    }
}
