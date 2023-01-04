<?php

namespace App\Providers\Admin;

use App\View\Components\Admin\BorderedAddBtn;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ComponentServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        Blade::component('bordered-add-btn', BorderedAddBtn::class);
    }
}
