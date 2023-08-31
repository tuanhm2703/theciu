<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class ComboStatusType extends Enum {
    const COMMING = 2;
    const HAPPENDING = 1;
    const STOPPED = 0;
    const PAUSE = 3;

    public static function getColorClass($status) {
        switch ($status) {
            case ComboStatusType::COMMING:
                return 'warning';
            case ComboStatusType::HAPPENDING:
                return "success";
            case ComboStatusType::STOPPED:
                return "danger";
            case ComboStatusType::PAUSE:
                return "light";
            default:
                return "danger";
        }
    }
}
