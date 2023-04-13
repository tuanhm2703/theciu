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
        Validator::extend('username_exists','App\Services\ValidationService@validCustomerUsername');
        Validator::extend('phone_number','App\Services\ValidationService@phoneNumber', trans('validation.phone_number'));
        Validator::extend('valid_username', 'App\Services\ValidationService@isValidUsername', trans('validation.invalid_username'));
        Validator::extend('username_have_not_been_used', 'App\Services\ValidationService@usernameHaveNotBeenUsed', trans('validation.username_have_been_used'));
        Validator::extend('password_match', 'App\Services\ValidationService@matchPassword', trans('validation.password_match'));
        Validator::extend('password_new', 'App\Services\ValidationService@passwordNotNew', trans('validation.password_new'));
        Validator::extend('correct_password','App\Services\ValidationService@correct_password');
    }
}
