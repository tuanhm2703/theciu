<?php

use App\Http\Controllers\Admin\OrderController;

Route::group(['prefix' => 'order', 'as' => 'order.'], function() {
    Route::get('{order}/details', [OrderController::class, 'details'])->name('details');
    Route::put('{order}/update-status', [OrderController::class, 'updateStatus'])->name('status.update');
    Route::get('{order}/pickup-address', [OrderController::class, 'choosePickupAddress'])->name('pickup_address.list');
    Route::put('{order}/accept', [OrderController::class, 'acceptOrder'])->name('accept');
});

Route::resource('order', OrderController::class);
