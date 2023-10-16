<?php

namespace App\Http\Services\VNPay\src;

use App\Http\Services\VNPay\src\Models\VNPayment;
use App\Http\Services\VNPay\src\Models\VNRefund;
use App\Models\Order;

class VNPayService {
    public static function checkout(Order $order) {
        if(auth('customer')->check()) {
            $redirectUrl = route('client.auth.profile.order.details', $order->id);
        } else {
            $redirectUrl = route('client.order.details', $order->id);
        }
        return VNPayment::process($order->order_number, (int) $order->customer_payment_amount * 100, $order->getCheckoutDescription(), $redirectUrl);
    }

    public static function refund(Order $order) {
        return VNRefund::process($order->order_number, $order->customer_payment_amount, $order->getRefundDescription(), $order->shipping_address->fullname, $order->payment->trans_id);
    }
}
