<?php

use App\Http\Controllers\Client\ProductController;

Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{slug}', [ProductController::class, 'details'])->name('details');
});
