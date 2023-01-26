<?php

use App\Http\Controllers\Admin\Ajax\ImageController;

Route::group(['prefix' => 'image', 'as' => 'image.'], function() {
    Route::post('upload', [ImageController::class, 'upload'])->name('upload');
    Route::put('update-order', [ImageController::class, 'updateOrder'])->name('update.order');
});
