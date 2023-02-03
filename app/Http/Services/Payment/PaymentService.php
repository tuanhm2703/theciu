<?php

namespace App\Http\Services\Payment;

use App\Enums\PaymentMethodType;
use App\Enums\PaymentServiceType;
use App\Enums\PaymentStatus;
use App\Http\Services\Momo\MomoService;

class PaymentService {
    public static function checkout($order) {
        switch ($order->payment_method->code) {
            case PaymentServiceType::MOMO:
                return MomoService::checkout($order);
            default:
                return route('client.auth.profile.index', ['tab' => 'order-list']);
        }
    }

    public static function refund($order) {
        if($order->payment && $order->payment->payment_status == PaymentStatus::PAID) {
            $payment_method = $order->payment->payment_method;
            if($payment_method->code == PaymentMethodType::MOMO) {
                MomoService::refund($order);
                return true;
            }
        }
        return false;
    }
}
