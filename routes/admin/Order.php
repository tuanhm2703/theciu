<?php

use App\Http\Controllers\Admin\OrderController;

Route::group(['prefix' => 'order', 'as' => 'order.'], function() {
    Route::get('{order}/details', [OrderController::class, 'details'])->name('details');
    Route::put('{order}/update-status', [OrderController::class, 'updateStatus'])->name('status.update');
    Route::get('{order}/pickup-address', [OrderController::class, 'choosePickupAddress'])->name('pickup_address.list');
    Route::put('{order}/accept', [OrderController::class, 'acceptOrder'])->name('accept');
    Route::get('{order}/cancel', [OrderController::class, 'viewCancelForm'])->name('view.cancel');
    Route::put('{order}/cancel', [OrderController::class, 'cancelOrder'])->name('cancel');
    Route::get('{order}/shipping-order', [OrderController::class, 'getShippingInfo'])->name('shipping_order');
    Route::get('{order}/shipping-order/print', [OrderController::class, 'printShippingOrderInfo'])->name('shipping_order.print');
});

Route::resource('order', OrderController::class);
