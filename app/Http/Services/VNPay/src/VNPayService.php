<?php

namespace App\Http\Services\VNPay\src;

use App\Http\Services\VNPay\src\Models\VNPayment;
use App\Http\Services\VNPay\src\Models\VNRefund;
use App\Models\Order;

class VNPayService {
    public static function checkout(Order $order) {
        return VNPayment::process($order->order_number, (int) $order->total * 100, $order->getCheckoutDescription(), route('client.auth.profile.order.details', $order->id));
    }

    public static function refund(Order $order) {
        return VNRefund::process($order->order_number, $order->total, $order->getRefundDescription(), $order->shipping_address->fullname, $order->payment->trans_id);
    }
}
