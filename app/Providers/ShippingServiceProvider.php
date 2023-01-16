<?php

namespace App\Providers;

use App\Http\Services\Shipping\GHTKService;
use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider
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
    $this->app->singleton(GHTKService::class);
    }
}
