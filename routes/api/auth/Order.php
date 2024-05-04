<?php

use App\Http\Controllers\Api\Auth\OrderController;

Route::group(['prefix' => 'orders', 'as' => 'order.'], function() {
    Route::get('/', [OrderController::class, 'index']);
});
