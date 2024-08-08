<?php

namespace App\Http\Services\Payment;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethodType;
use App\Enums\PaymentServiceType;
use App\Enums\PaymentStatus;
use App\Http\Services\Momo\MomoService;
use App\Http\Services\VNPay\src\Models\VNPayment;
use App\Http\Services\VNPay\src\Models\VNRefund;
use App\Http\Services\VNPay\src\VNPayService;
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
            case PaymentServiceType::COD:
                if (auth('customer')->check()) {
                    $redirectUrl = route('client.auth.profile.order.details', $order->id);
                } else {
                    $redirectUrl = route('client.order.details', $order->id);
                }
                return $redirectUrl;
            case PaymentServiceType::VNPAY:
                return VNPayment::process($order->order_number, (int) $order->total * 100, $order->getCheckoutDescription(), route('client.auth.profile.order.details', $order->id));
            default:
                throw new Exception('Dịch vụ thanh toán không hợp lệ.');
        }
    }
    public static function checkoutV2($order) {
        if ($order->isPaid()) {
            throw new Exception('Đơn hàng đã được thanh toán.');
        }
        switch ($order->payment_method->code) {
            case PaymentServiceType::MOMO:
                return MomoService::checkoutV2($order, RequestType::CAPTURE_MOMO_WALLET);
            case PaymentServiceType::EBANK:
                return MomoService::checkoutV2($order, RequestType::PAY_WITH_ATM);
            case PaymentServiceType::COD:
                if (auth('customer')->check()) {
                    $redirectUrl = env('FRONTEND_URL') . "/profile/order";
                } else {
                    $redirectUrl = env('FRONTEND_URL') . "/profile/order";
                }
                return $redirectUrl;
            case PaymentServiceType::VNPAY:
                return VNPayment::process($order->order_number, (int) $order->total * 100, $order->getCheckoutDescription(), env('FRONTEND_URL') . "/profile/order");
            default:
                throw new Exception('Dịch vụ thanh toán không hợp lệ.');
        }
    }

    public static function refund($order) {
        if ($order->order_status != OrderStatus::CANCELED) {
            throw new Exception('Không thể hoàn tiền đơn hàng chưa huỷ.', 409);
        }
        $result = false;
        if ($order->payment && $order->payment->payment_status == PaymentStatus::PAID) {
            $payment_method = $order->payment->payment_method;
            if (in_array($payment_method->type, PaymentMethodType::REFUNDABLE_METHODS)) {
                switch ($payment_method->code) {
                    case PaymentMethodType::MOMO:
                        MomoService::refund($order);
                        $result = true;
                        break;
                    case PaymentMethodType::VNPAY:
                        $result = VNPayService::refund($order);
                        break;
                }
                if (!$result) {
                }
            }
        }
        if ($result) $order->payment->update(['payment_status' => PaymentStatus::REFUND]);
        else $order->payment->update(['payment_status' => PaymentStatus::REFUND_FAILED]);
        return false;
    }
}
