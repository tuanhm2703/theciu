<?php

use App\Http\Controllers\Client\ProductController;

Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/sale-off', [ProductController::class, 'saleOff'])->name('sale_off');
    Route::get('/my-wishlist', [ProductController::class, 'myWishlist'])->name('my_wishlist');
    Route::get('/{slug}', [ProductController::class, 'details'])->name('details');
});
