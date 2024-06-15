<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class VietGuysServiceProvider extends ServiceProvider
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
        $this->app->singleton('VietGuysRefreshToken', function() {
            return Setting::getVietGuysRefreshToken();
        });
        $this->app->singleton('VietGuysAccessToken', function() {
            return Setting::getVietGuysAccessToken();
        });
        $this->app->singleton('VietGuysUsername', function() {
            return Setting::getVietGuysUsername();
        });
        $this->app->singleton('VietGuysBrandName', function() {
            return Setting::getVietGuysBrandName();
        });
        $this->app->singleton('VietGuysConfig', function() {
            return Setting::firstOrCreate([
                'name' => 'vietguys_config'
            ], [
                'data' => [
                    'refresh_token' => "",
                    'access_token' => "",
                    'username' => '',
                    'brand_name' => '',
                ]
            ]);
        });
    }
}
