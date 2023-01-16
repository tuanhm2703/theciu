<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver {
    public function creating(Order $order) {
        $order->order_number = (time() + (10 * 24 * 60 * 60))."";
    }
}
