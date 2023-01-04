<?php

namespace App\Providers;

use App\Services\BatchService;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
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
        // \URL::forceScheme('https');
        Carbon::setLocale(App::getLocale());
        $this->app->singleton(BatchService::class);
    }
}
