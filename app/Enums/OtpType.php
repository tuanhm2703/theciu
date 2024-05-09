<?php

namespace App\Enums;

class OtpType {
    const RESET_PASSWORD = 'reset_password';
    const LOGIN = 'login';
    const REGISTER = 'register';

    public static function all() {
        return [
            self::RESET_PASSWORD,
            self::LOGIN,
            self::REGISTER,
        ];
    }
}
