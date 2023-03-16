<?php

use App\Http\Controllers\Client\PageController;

Route::group(['prefix' => 'page', 'as' => 'page.'], function() {
    Route::get('chinh-sach-bao-hanh-va-doi-san-pham', [PageController::class, 'productExchangeAndWarranty'])->name('product_exchange_and_warranty');
    Route::get('thanh-toan-va-van-chuyen', [PageController::class, 'paymentAndShipping'])->name('payment_and_shipping');
    Route::get('about', [PageController::class, 'about'])->name('about');
    Route::get('ho-tro-dich-vu', [PageController::class, 'customerService'])->name('customer_service');
    Route::get('thanh-toan-an-toan', [PageController::class, 'paymentSafety'])->name('payment_safety');
    Route::get('{slug}', [PageController::class, 'details'])->name('details');
});
