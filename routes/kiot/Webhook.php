<?php

use App\Http\Controllers\Webhook\WarehouseWebhookController;

Route::group(['prefix' => 'webhook', 'as' => 'webhook.'], function() {
    Route::group(['as' => 'warehouse.', 'prefix' => 'warehouse'], function() {
        Route::post('/kiotviet', [WarehouseWebhookController::class, 'updateKiotProduct'])->name('kiotviet');
    });
});
