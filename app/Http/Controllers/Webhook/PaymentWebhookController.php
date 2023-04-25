<?php

namespace App\Http\Controllers\Webhook;

use App\Enums\OrderStatus;
use App\Enums\OrderSubStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Webhook\MomoWebhookRequest;
use App\Http\Requests\Webhook\VNPaywebhookRequest;
use App\Http\Services\VNPay\src\Models\Param;
use App\Http\Services\VNPay\src\Models\VNPayment;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use MService\Payment\Pay\Models\ResultCode;

class PaymentWebhookController extends Controller
{
    public function momoWebhook(Order $order, MomoWebhookRequest $request)
    {
        $order_number = base64_decode($request->extraData);
        if ($order->order_number == $order_number) {
            $resultCode = $request->resultCode;
            if ($resultCode == ResultCode::SUCCESS) {
                $order->payment->data = $request->except(['partnerCode']);
                $order->payment->payment_status = PaymentStatus::PAID;
                $order->payment->note = $request->message;
                $order->payment->trans_id = $request->transId;
                $order->order_status = OrderStatus::WAITING_TO_PICK;
                $order->sub_status = OrderSubStatus::PREPARING;
                $order->payment->save();
                $order->save();
                $order->createPaymentOrderHistory();
            }
        } else {
            throw new Exception('Order id not match with platform order', 409);
        }
        return response()->json([], 204);
    }

    public function vnpayWebhook(VNPaywebhookRequest $request)
    {
        try {
            $orderNumber = $request->{Param::TXN_REF};
            $order = Order::where('order_number', $orderNumber)->first();
            $returnData = [];
            if (!$order) {
                $returnData['RspCode'] = '01';
                $returnData['Message'] = 'Order Not Found';
                return response()->json($returnData);
            }
            if (VNPayment::checkSum($request->all())) {
                if ($order->total * 100 != $request->{Param::AMOUNT}) {
                    $returnData['RspCode'] = '04';
                    $returnData['Message'] = 'Invalid amount';
                } else {
                    if ($order->payment->payment_status != PaymentStatus::PENDING) {
                        $returnData['RspCode'] = '02';
                        $returnData['Message'] = 'Order is not on pending status';
                    } else {
                        $returnData['RspCode'] = '00';
                        $returnData['Message'] = 'Confirm Success';
                        if ($request->{Param::RESPONSE_CODE} == '00') {
                            $order->payment->data = $request->all();
                            $order->payment->payment_status = PaymentStatus::PAID;
                            $order->payment->trans_id = $request->{Param::TRANSACTION_NUMBER};
                            $order->order_status = OrderStatus::WAITING_TO_PICK;
                            $order->sub_status = OrderSubStatus::PREPARING;
                            $order->payment->save();
                            $order->save();
                            $order->createPaymentOrderHistory();
                        } else {
                            $order->payment->payment_status = PaymentStatus::FAILED;
                            $order->payment->payment_status = PaymentStatus::PENDING;
                            $order->payment->trans_id = $request->{Param::TRANSACTION_NUMBER};
                            $order->payment->save();
                        }
                    }
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (\Throwable $th) {
            \Log::error($th);
            $returnData['RspCode'] = '97';
            $returnData['Message'] = 'Invalid signature';
        }
        return response()->json($returnData);
    }
}
