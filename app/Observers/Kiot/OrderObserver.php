<?php

namespace App\Observers\Kiot;

use App\Enums\OrderStatus;
use App\Enums\OrderSubStatus;
use App\Events\Kiot\OrderCanceledEvent;
use App\Events\Kiot\OrderDeliveredEvent;
use App\Events\Kiot\OrderWaitToPickEvent;
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
        if($order->isDirty('sub_status')) {
            if($order->sub_status == OrderSubStatus::FINISH_PACKAGING) {
                event(new OrderWaitToPickEvent($order));
            }
        }
    }
}
