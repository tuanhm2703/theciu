<?php

use App\Http\Controllers\Client\PageController;

Route::group(['prefix' => 'page', 'as' => 'page.', 'middleware' => ['cacheResponse:1']], function() {
    // Route::get('chinh-sach-bao-hanh-va-doi-san-pham', [PageController::class, 'productExchangeAndWarranty'])->name('product_exchange_and_warranty');
    Route::get('thanh-toan', [PageController::class, 'payment'])->name('payment');
    Route::get('van-chuyen', [PageController::class, 'shipment'])->name('shipment');
    Route::get('branch', [PageController::class, 'branch'])->name('branch');
    // Route::get('about', [PageController::class, 'about'])->name('about');
    // Route::get('lien-he', [PageController::class, 'contact'])->name('contact');
    // Route::get('ho-tro-dich-vu', [PageController::class, 'customerService'])->name('customer_service');
    // Route::get('thanh-toan-an-toan', [PageController::class, 'paymentSafety'])->name('payment_safety');
    Route::get('{slug}', [PageController::class, 'details'])->name('details');
});
