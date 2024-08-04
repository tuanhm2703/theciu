<?php

use App\Http\Controllers\Api\Auth\CartController;

Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'addToCart']);
    Route::post('/remove', [CartController::class, 'removeFromCart']);
    Route::post('/selectItem', [CartController::class, 'selectItem']);
    Route::post('/unselectItem', [CartController::class, 'unselectItem']);
    Route::post('/changeProductInventory', [CartController::class, 'changeProductInventory']);
    Route::post('checkout', [CartController::class, 'checkout']);
});
