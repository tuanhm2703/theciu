<?php

use App\Http\Controllers\Client\OrderController;

Route::group(['prefix' => 'order', 'as' => 'order.'], function() {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}/details', [OrderController::class, 'details'])->name('details');
    Route::get('/{order}/cancel', [OrderController::class, 'showCancelForm'])->name('cancel.show');
    Route::put('{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    Route::get('{order}/shipping-detail', [OrderController::class, 'getShippingOrderDetail'])->name('shipping.detail');
    Route::get('{order}/review', [OrderController::class, 'getReviewForm'])->name('review');
});
