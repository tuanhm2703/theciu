<?php

namespace App\Observers\Kiot;

use App\Enums\OrderStatus;
use App\Events\Kiot\OrderCanceledEvent;
use App\Events\Kiot\OrderDeliveredEvent;
use App\Models\Order;

class OrderObserver
{
    public function updated(Order $order) {
        if ($order->isDirty('order_status')) {
            switch ($order->order_status) {
                case OrderStatus::CANCELED:
                    event(new OrderCanceledEvent($order));
                    break;
                case OrderStatus::WAITING_TO_PICK:
                    break;
                case OrderStatus::DELIVERING:
                    break;
                case OrderStatus::DELIVERED:
                    event(new OrderDeliveredEvent($order));
                    break;
            }
        }
    }
}
