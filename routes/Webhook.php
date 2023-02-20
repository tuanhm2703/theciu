<?php

use App\Http\Controllers\Webhook\PaymentWebhookController;
use App\Http\Controllers\Webhook\ShippingWebhookController;
use App\Http\Controllers\Webhook\WarehouseWebhookController;

Route::group(['prefix' => 'webhook', 'as' => 'webhook.'], function() {
    Route::group(['as' => 'shipping.', 'prefix' => 'shipping', 'middleware' => 'white_list_shipping'], function () {
        Route::post('/{service_alias}/webhook', [ShippingWebhookController::class, 'postWebhook'])->name('webhook');
    });

    Route::group(['as' => 'payment.', 'prefix' => 'payment'], function() {
        Route::post('/momo/{order}', [PaymentWebhookController::class, 'momoWebhook'])->name('momo');
        Route::post('/vnpay', [PaymentWebhookController::class, 'vnpayWebhook'])->name('vnpay');
    });

    Route::group(['as' => 'warehouse.', 'prefix' => 'warehouse'], function() {
        Route::post('/kiotviet', [WarehouseWebhookController::class, 'updateKiotProduct'])->name('kiotviet');
    });
});
