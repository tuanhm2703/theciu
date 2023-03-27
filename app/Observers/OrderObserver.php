<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Enums\OrderSubStatus;
use App\Events\OrderCanceled;
use App\Events\OrderCreatedEvent;
use App\Models\Order;
use Exception;

class OrderObserver {
    public function created(Order $order) {

    }
    public function creating(Order $order) {
        $order->migrateOrderNumber();
    }

    public function updating(Order $order) {
        $original_status = $order->getOriginal('order_status');
        if ($original_status == OrderStatus::CANCELED) {
            throw new Exception('Không thể thay đổi trạng thái đơn hàng khi đơn hàng đã bị hủy.', 409);
        }
        if($order->isDirty('order_status') || $order->isDirty('sub_status')) {
            if($order->canAction() || $order->order_status == OrderStatus::CANCELED) {
                if ($order->isDirty('order_status')) {
                    $order->createOrderHistory();
                }
            } else {
                throw new Exception('Đơn hàng chưa được khách hàng thanh toán.', 409);
            }
        }
    }

    public function updated(Order $order) {
        if ($order->isDirty('order_status')) {
            switch ($order->order_status) {
                case OrderStatus::CANCELED:
                    event(new OrderCanceled($order));
                    break;
                case OrderStatus::WAITING_TO_PICK:
                    break;
                case OrderStatus::DELIVERING:
                    break;
                case OrderStatus::DELIVERED:
                    break;
            }
        }
        if($order->isDirty('sub_status')) {
            if($order->sub_status == OrderSubStatus::FINISH_PACKAGING) {
                $order->pushShippingOrder();
            }
        }
    }
}
