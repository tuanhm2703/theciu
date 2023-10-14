<?php

use App\Http\Controllers\Api\BlogController;

Route::group(['prefix' => 'blogs'], function() {
    Route::get('/', [BlogController::class, 'index']);
    Route::get('/{slug}', [BlogController::class, 'detail']);
});
