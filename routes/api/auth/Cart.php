<?php

use App\Http\Controllers\Api\Auth\CartController;

Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'addToCart']);
    Route::post('/remove', [CartController::class, 'removeFromCart']);
});
