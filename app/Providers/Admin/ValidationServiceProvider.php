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
    }
}
