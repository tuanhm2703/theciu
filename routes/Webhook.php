<?php

use App\Http\Controllers\Webhook\PaymentWebhookController;
use App\Http\Controllers\Webhook\ShippingWebhookController;

Route::group(['prefix' => 'webhook', 'as' => 'webhook.'], function() {
    Route::group(['as' => 'shipping.', 'prefix' => 'shipping', 'middleware' => 'white_list_shipping'], function () {
        Route::post('/{service_alias}/webhook', [ShippingWebhookController::class, 'postWebhook'])->name('webhook');
    });

    Route::group(['as' => 'payment.', 'prefix' => 'payment'], function() {
        Route::post('/{order}', [PaymentWebhookController::class, 'momoWebhook'])->name('momo');
    });
});
