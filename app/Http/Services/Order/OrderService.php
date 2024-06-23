<?php

namespace App\Http\Services\Order;

use App\Enums\OrderStatus;
use App\Exceptions\Api\ApiException;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService {
    public function cancel(Order $order, ?string $reason) {
        DB::beginTransaction();
        try {
            $order->cancel_reason = $reason;
            $order->order_status = OrderStatus::CANCELED;
            $order->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new ApiException("Huỷ đơn hàng thất bại");
        }
        DB::commit();
    }
}
