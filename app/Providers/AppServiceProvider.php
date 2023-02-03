<?php

namespace App\Providers;

use App\Http\Services\Momo\MomoService;
use App\Services\BatchService;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if(env('APP_ENV') != 'local') {
            URL::forceScheme('https');
        }
        Carbon::setLocale(App::getLocale());
        $this->app->singleton(BatchService::class);
        $this->app->singleton(MomoService::class);
    }
}
