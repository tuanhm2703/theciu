<?php

use App\Http\Controllers\Admin\VietGuysController;

Route::group(['prefix' => 'vietguys', 'as' => 'vietguys.'], function() {
    Route::get('/', [VietGuysController::class, 'index'])->name('index');
    Route::put('/', [VietGuysController::class, 'update'])->name('update');
    Route::get('/authorize', [VietGuysController::class, 'authShop'])->name('authorize');
    Route::get('/auth/redirect', [VietGuysController::class, 'authRedirect'])->name('auth.redirect');
});
