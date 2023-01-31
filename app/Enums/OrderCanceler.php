<?php
namespace App\Enums;

class OrderCanceler {
    const SHOP = 1;
    const CUSTOMER = 2;
    const SHIPPING_SERVICE = 3;
    const SYSTEM = 4;

    public static function getCancelerLabel($canceler) {
        switch ($canceler) {
            case self::SHOP:
                return 'Cửa hàng';
            case self::CUSTOMER:
                return 'Người mua';
            case self::SHIPPING_SERVICE:
                return 'Dịch vụ vận chuyển';
            default:
                return 'Hệ thống';
        }
    }
}
