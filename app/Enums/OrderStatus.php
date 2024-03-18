<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class OrderStatus extends Enum {
    const ALL = 0;
    const WAIT_TO_ACCEPT = 1;
    const WAITING_TO_PICK = 2;
    const PICKING = 3;
    const DELIVERING = 4;
    const DELIVERED = 5;
    const CANCELED = 6;
    const RETURN = 7;

    public static function getStatusOptions() {
        return [
            self::ALL => 'Tất cả',
            self::WAIT_TO_ACCEPT => __('order.order_status.wait_to_accept'),
            self::WAITING_TO_PICK => __('order.order_status.waiting_to_pick'),
            self::PICKING => __('order.order_status.picking'),
            self::DELIVERING => __('order.order_status.delivering'),
            self::DELIVERED => __('order.order_status.delivered'),
            self::CANCELED => __('order.order_status.canceled'),
        ];
    }

    public static function processingStatus() {
        return [
            self::WAITING_TO_PICK,
            self::WAIT_TO_ACCEPT,
            self::PICKING,
            self::DELIVERING
        ];
    }
}
