<?php

namespace App\Http\Services\Payment;

use App\Enums\PaymentServiceType;
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
}
