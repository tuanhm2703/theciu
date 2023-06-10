<?php

namespace App\Providers;

use App\Http\Services\Momo\MomoService;
use App\Interfaces\AppConfig;
use App\Models\Category;
use App\Models\Config;
use App\Models\Setting;
use App\Services\BatchService;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use VienThuong\KiotVietClient\Client;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        if (env('APP_ENV') != 'local') {
            URL::forceScheme('https');
        }
        Carbon::setLocale(App::getLocale());
        $this->app->singleton(BatchService::class);
        $this->app->singleton(MomoService::class);
        $this->app->singleton(Client::class, function() {
            $client = new Client(config('services.kiotviet.client_id'), config('services.kiotviet.client_secret'), [], config('services.kiotviet.retailer'));
            $client->fetchAccessToken();
            return $client;
        });
        $this->app->singleton('AppConfig', function() {
            return Cache::remember('app_config', 600, function () {
                return Config::first();
            });;
        });
        $this->app->singleton('ProductCategory', function() {
            return Category::getMenuCategories();
        });
    }
}
