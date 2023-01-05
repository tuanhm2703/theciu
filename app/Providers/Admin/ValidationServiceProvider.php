<?php

namespace App\Providers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        Validator::extend('valid_promotion_inventory','App\Services\ValidationService@validPromotionInventory');
        Validator::extend('username_exists','App\Services\ValidationService@validPromotionInventory');
        Validator::extend('phone_number','App\Services\ValidationService@phoneNumber');
        Validator::extend('valid_username', 'App\Services\ValidationService@isValidUsername', trans('validation.invalid_username'));
        Validator::extend('username_have_not_been_used', 'App\Services\ValidationService@usernameHaveNotBeenUsed', trans('validation.username_have_been_used'));
    }
}
