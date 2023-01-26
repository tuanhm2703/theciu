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
        return view('admin.pages.order.details', compact('order'));
    }
}
