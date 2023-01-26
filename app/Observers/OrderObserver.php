<?php

namespace App\Observers;

use App\Enums\OrderSubStatus;
use App\Models\Order;

class OrderObserver {
    public function creating(Order $order) {
        $order->order_number = (time() + (10 * 24 * 60 * 60))."";
    }

    public function updated(Order $order) {
        if($order->isDirty('sub_status') && $order->sub_status == OrderSubStatus::FINISH_PACKAGING) {
            $order->pushShippingOrder();
        }
    }
}
