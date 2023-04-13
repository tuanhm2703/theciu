<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ValidationService {
    public static function validPromotionInventory($attribute, $value, $parameters) {
        return true;
    }

    public static function validCustomerUsername($attribute, $value, $parameters) {
        return Customer::where('phone', $value)->orWhere('email', $value)->exists();
    }

    public static function phoneNumber($attribute, $value, $parameters) {
        return isPhone($value);
    }

    public static function isValidUsername($attribute, $value, $parameters) {
        return isPhone($value) || isEmail($value);
    }

    public static function usernameHaveNotBeenUsed($attribute, $value, $parameters) {
        return Customer::where('phone', $value)->orWhere('email', $value)->doesntExist();
    }

    public static function matchPassword($attribute, $value, $parameters) {
        $oldPassword = $parameters[0];
        return Hash::check($value, $oldPassword);
    }

    public static function passwordNotNew($attribute, $value, $parameters) {
        $oldPassword = $parameters[0];
        return !Hash::check($value, $oldPassword);
    }

    public static function correct_password($attribute, $value, $parameters) {
        $table = $parameters[0];
        $username = $parameters[1];
        $user = DB::table($table)->where(function($q) use ($username) {
            $q->where('email', $username)->orWhere('phone', $username);
        })->first();
        if($user) {
            return Hash::check($value, $user->password);
        }
        return false;
    }
}
