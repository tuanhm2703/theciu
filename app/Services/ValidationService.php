<?php

namespace App\Services;

class ValidationService {
    public static function validPromotionInventory($attribute, $value, $parameters) {
        \Log::info($attribute);
        return true;
    }
}
