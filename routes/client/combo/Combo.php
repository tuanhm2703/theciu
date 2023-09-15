<?php

use App\Http\Controllers\Client\ComboController;

Route::group(['prefix' => 'combo', 'as' => 'combo.'], function() {
    Route::get('/', [ComboController::class, 'index'])->name('index')->middleware('cacheResponse:300');
});
