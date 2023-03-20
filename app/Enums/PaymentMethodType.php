<?php

namespace App\Enums;

class PaymentMethodType {
    const COD = 1;
    const EWALLET = 2;
    const EBANK = 3;

    const MOMO = 'momo';

    const VNPAY = 'vnpay';

    const REFUNDABLE_METHODS = [self::EWALLET, self::EBANK];

    public static function getKiotMethodType($code) {
        switch ($code) {
            case self::COD:
                return 'Cash';
                break;
            default:
                return 'Transfer';
                break;
        }
    }
}
