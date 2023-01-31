<?php

namespace App\Http\Controllers\Client;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index() {
        $orders = auth('customer')->user()->orders()->with('inventories.image')->get();
        return view('landingpage.layouts.pages.order.index', compact('orders'));
    }

    public function pay() {

    }

    public function cancel(Order $order, Request $request) {
        $cancel_reason = $request->cancel_reason;
        $order->cancel_reason = $cancel_reason;
        $order->order_status = OrderStatus::CANCELED;
        $order->save();
        return BaseResponse::success([
            'message' => 'Huỷ đơn hàng thành công'
        ]);
    }
    public function showCancelForm(Order $order) {
        return view('landingpage.layouts.pages.profile.components.order-cancel-form', compact('order'));
    }
}
