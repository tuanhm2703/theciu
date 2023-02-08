<?php

namespace App\Http\Services\Payment;

use App\Enums\PaymentMethodType;
use App\Enums\PaymentServiceType;
use App\Enums\PaymentStatus;
use App\Http\Services\Momo\MomoService;
use Exception;
use MService\Payment\Shared\Constants\RequestType;

class PaymentService {
    public static function checkout($order) {
        if ($order->isPaid()) {
            throw new Exception('Đơn hàng đã được thanh toán.');
        }
        switch ($order->payment_method->code) {
            case PaymentServiceType::MOMO:
                return MomoService::checkout($order, RequestType::CAPTURE_MOMO_WALLET);
            case PaymentServiceType::EBANK:
                return MomoService::checkout($order, RequestType::PAY_WITH_ATM);
            default:
                throw new Exception('Dịch vụ thanh toán không hợp lệ.');
        }
    }

    public static function refund($order) {
        if ($order->payment && $order->payment->payment_status == PaymentStatus::PAID) {
            $payment_method = $order->payment->payment_method;
            if (in_array($payment_method->code, PaymentMethodType::REFUNDABLE_METHODS)) {
                MomoService::refund($order);
                return true;
            }
        }
        return false;
    }
}
