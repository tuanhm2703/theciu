<?php

use App\Http\Controllers\Api\ConfigController;

Route::group(['prefix' => 'config'], function() {
    Route::get('/', [ConfigController::class, 'getGeneralConfig']);
});
