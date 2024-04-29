<?php

use App\Http\Controllers\Admin\ShopeeController;

Route::group(['prefix' => 'shopee', 'as' => 'shopee.'], function() {
    Route::get('/', [ShopeeController::class, 'index'])->name('index');
    Route::put('/', [ShopeeController::class, 'update'])->name('update');
    Route::get('/authorize', [ShopeeController::class, 'authShop'])->name('authorize');
    Route::get('/auth/redirect', [ShopeeController::class, 'authRedirect'])->name('auth.redirect');
});
