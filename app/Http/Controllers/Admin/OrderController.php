<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\OrderSubStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Http\Requests\Admin\ViewOrderRequest;
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
    public function index(ViewOrderRequest $request) {
        return view('admin.pages.order.index');
    }

    public function updateStatus(Order $order, UpdateOrderRequest $request) {
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

    public function choosePickupAddress(UpdateOrderRequest $request, Order $order) {
        $pickup_shifts = App::make(GHTKService::class)->getListPickupTime();
        $pickup_shifts = collect($pickup_shifts)->pluck('time', 'id')->toArray();
        $pickup_addresses = App::get('AppConfig')->pickup_addresses()->get();
        return view('admin.pages.order.components.pickup_address_selector', compact('order', 'pickup_shifts', 'pickup_addresses'));
    }

    public function acceptOrder(Order $order, UpdateOrderRequest $request) {
        DB::beginTransaction();
        try {
            $address = $request->has('pickup_address_id') ? Address::find($request->pickup_address_id) : App::get('AppConfig')->pickup_address;
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

    public function details(ViewOrderRequest $request, Order $order) {
        $total_delivered_orders = $order->customer->delivered_orders()->count();
        $order_success_percentage = $order->customer->order_success_percentage();
        $order->shipping_order->setRelation('shipping_order_histories', $order->shipping_order->shipping_order_histories()->orderBy('created_at', 'desc')->get());
        return view('admin.pages.order.details', compact('order', 'total_delivered_orders', 'order_success_percentage'));
    }

    public function viewCancelForm(ViewOrderRequest $request, Order $order) {
        return view('admin.pages.order.components.cancel_form', compact('order'));
    }

    public function cancelOrder(Order $order, UpdateOrderRequest $request) {
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

    public function getShippingInfo(ViewOrderRequest $request, Order $order) {
        return view('admin.pages.order.components.details.shipping_order_info', compact('order'));
    }

    public function printShippingOrderInfo(Order $order, ViewOrderRequest $request) {
        return App::make(GHTKService::class)->printOrder($order->shipping_order->code);
    }

    public function batchFinishPackaging(Request $request) {
        $orders = Order::whereIn('id', $request->order_ids)->get();
        $orders->each(function($order) {
            $order->action_url = route('admin.order.accept', $order->id);
        });
        return view('admin.pages.order.components.batch.finish_packaging', compact('orders'));
    }
}
