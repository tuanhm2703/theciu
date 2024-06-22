<?php

use App\Http\Controllers\Webhook\BlogWebhookController;
use App\Http\Controllers\Webhook\PaymentWebhookController;
use App\Http\Controllers\Webhook\ShippingWebhookController;
use App\Http\Controllers\Webhook\WarehouseWebhookController;

Route::group(['prefix' => 'webhook', 'as' => 'webhook.'], function() {
    Route::group(['as' => 'shipping.', 'prefix' => 'shipping', 'middleware' => 'white_list_shipping'], function () {
        Route::post('/{service_alias}/webhook', [ShippingWebhookController::class, 'postWebhook'])->name('webhook');
    });

    Route::group(['as' => 'payment.', 'prefix' => 'payment'], function() {
        Route::post('/momo/{order}', [PaymentWebhookController::class, 'momoWebhook'])->name('momo');
        Route::get('/vnpay', [PaymentWebhookController::class, 'vnpayWebhook'])->name('vnpay');
    });
    Route::group(['as' => 'blog', 'prefix' => 'blog'], function() {
        Route::post('/', [BlogWebhookController::class, 'webhook']);
    });
});
