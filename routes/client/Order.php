<?php

use App\Http\Controllers\Client\SessionOrderController;

Route::group(['prefix' => 'order', 'as' => 'order.'], function() {
    Route::get('/', [SessionOrderController::class, 'index'])->name('index');
    Route::get('/{order}/details', [SessionOrderController::class, 'details'])->name('details');
    Route::get('/{order}/cancel', [SessionOrderController::class, 'showCancelForm'])->name('cancel.show');
    Route::put('{order}/cancel', [SessionOrderController::class, 'cancel'])->name('cancel');
    Route::get('{order}/shipping-detail', [SessionOrderController::class, 'getShippingOrderDetail'])->name('shipping.detail');
    Route::get('{order}/review', [SessionOrderController::class, 'getReviewForm'])->name('review');
});
