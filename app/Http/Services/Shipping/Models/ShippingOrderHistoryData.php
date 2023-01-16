<?php
namespace App\Http\Services\Shipping\Models;

class ShippingOrderHistoryData {
    public $shipping_order_id;
    public $status;
    public $time;
    public $reason;
    public $fee;
    public $cod_amount;
    public $status_code;
    public $order_status_id;
    public $reason_code = null;
    public $warehouse = '';
    public $description;
    public function __construct() {
        $get_arguments       = func_get_args();
        $number_of_arguments = func_num_args();
        if($number_of_arguments == 7) {
            if (method_exists($this, $method_name = '__construct1')) {
                call_user_func_array(array($this, $method_name), $get_arguments);
            }
        }
    }
    public function __construct1($shipping_order_id, $status, $time, $reason, $fee, $cod_amount, $status_code) {
        $this->shipping_order_id = $shipping_order_id;
        $this->status = $status;
        $this->time = $time;
        $this->reason = $reason;
        $this->fee = $fee;
        $this->cod_amount = $cod_amount;
        $this->status_code = $status_code;
    }
    public function toArray() {
        return (array) $this;
    }
}
