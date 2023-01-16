<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class ShippingServiceType extends Enum {
    const GIAO_HANG_NHANH_ALIAS = 'giao-hang-nhanh';
    const GIAO_HANG_TIET_KIEM_ALIAS = 'giao-hang-tiet-kiem';
    const BONUS_DAYS_ORDER_CAN_DELAYED = 3;


    const FAST_SHIPPING_SERVICE_CODE = 1;
    const STANDARD_SHIPPING_SERVICE_CODE = 2;
    const SAVE_SHIPPING_SERVICE_CODE = 3;

    const FAST_SHIPPING_SERVICE_NAME = 'Nhanh';
    const STANDARD_SHIPPING_SERVICE_NAME = 'Tiêu chuẩn';
    const SAVE_SHIPPING_SERVICE_NAME = 'Tiết kiệm';
}
