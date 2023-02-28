<?php

use App\Http\Controllers\Admin\ShopConfigController;

Route::group(['prefix' => 'shop', 'as' => 'shop.'], function() {
    Route::get('/', [ShopConfigController::class, 'index'])->name('index');
});
