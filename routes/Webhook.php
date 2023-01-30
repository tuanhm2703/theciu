<?php

use App\Http\Controllers\ShippingWebhookController;

Route::group(['as' => 'shipping.', 'prefix' => 'shipping', 'middleware' => 'white_list_shipping'], function () {
    Route::post('/{service_alias}/webhook', [ShippingWebhookController::class, 'postWebhook'])->name('webhook');
});
