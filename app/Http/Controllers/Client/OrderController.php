<?php

namespace App\Http\Controllers\Client;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {
    public function index() {
        return view('landingpage.layouts.pages.profile.order');
    }

    public function pay() {
    }

    public function cancel(Order $order, Request $request) {
        DB::beginTransaction();
        try {
            $cancel_reason = $request->cancel_reason;
            $order->cancel_reason = $cancel_reason;
            $order->order_status = OrderStatus::CANCELED;
            $order->save();
            DB::commit();
        } catch (\Throwable $th) {
            \Log::info($th);
            DB::rollBack();
            return BaseResponse::error([
                'message' => 'Huỷ đơn hàng thành công, vui lòng liên hệ bộ phận chăm sóc khách hàng để xử lý'
            ]);
        }
        return BaseResponse::success([
            'message' => 'Huỷ đơn hàng thành công'
        ]);
    }
    public function showCancelForm(Order $order) {
        return view('landingpage.layouts.pages.profile.components.order-cancel-form', compact('order'));
    }

    public function details(Order $order) {
        $order->setRelation('order_histories', $order->order_histories()->with('action')->reorder()->orderBy('created_at', 'asc')->get());
        $order->setRelation('shipping_order', $order->shipping_order()->with(['shipping_order_histories' => function ($q) {
            return $q->orderBy('shipping_order_histories.created_at', 'desc');
        }])->first());
        return view('landingpage.layouts.pages.order.details', compact('order'));
    }
}
