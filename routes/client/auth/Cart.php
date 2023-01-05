<?php

use App\Http\Controllers\Client\Auth\CartController;

Route::group(['prefix' => 'cart', 'as' => 'cart.'], function() {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'addToCart'])->name('add');
    Route::delete('/remove', [CartController::class, 'removeFromCart'])->name('remove');
});
