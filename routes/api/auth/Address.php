<?php

use App\Http\Controllers\Api\Auth\AddressController;

Route::group(['prefix' => 'addresses', 'as' => 'address'], function() {
    Route::get('provinces', [AddressController::class, 'provinces']);
    Route::get('districts', [AddressController::class, 'districts']);
    Route::get('wards', [AddressController::class, 'wards']);
    Route::get('/', [AddressController::class, 'addresses']);
    Route::delete('/{address}', [AddressController::class, 'destroy']);
    Route::put('/{address}', [AddressController::class, 'update']);
    Route::post('/', [AddressController::class, 'store']);
});
