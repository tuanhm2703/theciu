<?php

namespace App\Services;

use App\Models\Customer;

class ValidationService {
    public static function validPromotionInventory($attribute, $value, $parameters) {
        return true;
    }

    public static function validCustomerUsername($attribute, $value, $parameters) {
        return Customer::where('phone', $value)->orWhere('email', $value)->exists();
    }
}
