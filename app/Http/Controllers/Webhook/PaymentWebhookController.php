<?php

namespace App\Http\Controllers\Webhook;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use MService\Payment\Pay\Models\ResultCode;

class PaymentWebhookController extends Controller {
    public function momoWebhook(Order $order, Request $request) {
        if ($order->order_number == $request->orderId) {
            $resultCode = $request->resultCode;
            if ($resultCode == ResultCode::SUCCESS) {
                $order->payment->data = $request->except(['partnerCode']);
                $order->payment->payment_status = PaymentStatus::PAID;
                $order->payment->note = $request->message;
                $order->payment->trans_id = $request->transId;
                $order->payment->save();
                $order->createPaymentOrderHistory();
            }
        } else {
            throw new Exception('Order id not match with platform order', 409);
        }
        return response()->json([], 204);
    }
}
