<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class PromotionStatusType extends Enum {
    const COMMING = 2;
    const HAPPENDING = 1;
    const STOPPED = 0;
    const PAUSE = 3;

    public static function getColorClass($status) {
        switch ($status) {
            case PromotionStatusType::COMMING:
                return 'warning';
            case PromotionStatusType::HAPPENDING:
                return "success";
            case PromotionStatusType::STOPPED:
                return "danger";
            case PromotionStatusType::PAUSE:
                return "light";
            default:
                return "danger";
        }
    }
}
