<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\OrderSubStatus;
use App\Http\Controllers\Controller;
use App\Http\Services\Shipping\GHTKService;
use App\Models\Address;
use App\Models\Config;
use App\Models\Order;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller {
    public function index() {
        return view('admin.pages.order.index');
    }

    public function updateStatus(Order $order, Request $request) {
        DB::beginTransaction();
        try {
            $order->update($request->all());
        } catch (\Throwable $th) {
            DB::rollBack();
            return BaseResponse::error([
                'message' => $th->getMessage()
            ]);
        }
        DB::commit();
        return BaseResponse::success([
            'message' => 'Cập nhật trạng thái đơn hàng thành công'
        ]);
    }

    public function choosePickupAddress(Order $order) {
        $pickup_shifts = App::make(GHTKService::class)->getListPickupTime();
        $pickup_shifts = collect($pickup_shifts)->pluck('time', 'id')->toArray();
        $pickup_addresses = Config::select('id')->first()->pickup_addresses()->get();
        return view('admin.pages.order.components.pickup_address_selector', compact('order', 'pickup_shifts', 'pickup_addresses'));
    }

    public function acceptOrder(Order $order, Request $request) {
        DB::beginTransaction();
        try {
            $address = Address::find($request->pickup_address_id);
            $data = $address->toArray();
            $data['addressable_id'] = $order->id;
            $order->addresses()->create($data);
            $order->sub_status = OrderSubStatus::FINISH_PACKAGING;
            $order->save();
            DB::commit();
        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollBack();
            return BaseResponse::error([
                'message' => $e->getMessage()
            ], 400);
        }
        return BaseResponse::success([
            'message' => 'Đơn hàng đã chuyển trạng thái chờ vận chuyển'
        ]);
    }

    public function details(Order $order) {
        $total_delivered_orders = $order->customer->delivered_orders()->count();
        $order_success_percentage = $order->customer->order_success_percentage();
        return view('admin.pages.order.details', compact('order', 'total_delivered_orders', 'order_success_percentage'));
    }

    public function viewCancelForm(Order $order) {
        return view('admin.pages.order.components.cancel_form', compact('order'));
    }

    public function cancelOrder(Order $order, Request $request) {
        DB::beginTransaction();
        try {
            if($request->other_reason) {
                $order->cancel_reason = $request->other_reason;
            } else {
                $order->cancel_reason = $request->cancel_reason;
            }
            $order->order_status = OrderStatus::CANCELED;
            $order->save();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return BaseResponse::error([
                'message' => $th->getMessage()
            ], $th->getCode());
        }
        DB::commit();
        return BaseResponse::success([
            'message' => 'Huỷ đơn hàng thành công'
        ]);
    }

    public function getShippingInfo(Order $order) {
        return view('admin.pages.order.components.details.shipping_order_info', compact('order'));
    }

    public function printShippingOrderInfo(Order $order) {
        return App::make(GHTKService::class)->printOrder($order->shipping_order->code);
    }
}
