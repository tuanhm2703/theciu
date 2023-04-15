<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
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
        $this->app->singleton('KiotConfig', function() {
            return Setting::getKiotSetting();
        });
        $this->app->singleton('WebsiteSetting', function() {
            return Setting::getWebsiteSetting();
        });
    }
}
