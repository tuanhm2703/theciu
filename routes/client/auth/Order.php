<?php

use App\Http\Controllers\Client\OrderController;

Route::group(['prefix' => 'order', 'as' => 'order.'], function() {
    Route::get('/', [OrderController::class, 'index'])->name('index');
});
