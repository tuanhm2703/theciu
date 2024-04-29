<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class ShopeeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('ShopeeConfig', function() {
            return Setting::getShopeeSettings()->data;
        });
        $this->app->singleton('ShopeeAccessToken', function() {
            return Setting::getShopeeAccessToken()->data;
        });
        $this->app->singleton('ShopeeRefreshToken', function() {
            return Setting::getShopeeRefreshToken()->data;
        });
        $this->app->singleton('ShopeeShopId', function() {
            return Setting::getShopeeShopid()->data;
        });

    }
}
