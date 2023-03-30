<?php

use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\ProductController;

Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/sale-off/{slug?}', [ProductController::class, 'saleOff'])->name('sale_off');
    Route::get('/new-arrival', [ProductController::class, 'newArrival'])->name('new_arrival');
    Route::get('/best-seller', [ProductController::class, 'bestSeller'])->name('best_seller');
    Route::get('/my-wishlist', [ProductController::class, 'myWishlist'])->name('my_wishlist');
    Route::get('/{slug}', [ProductController::class, 'details'])->name('details');
});
Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
    Route::get('/{type}', [CategoryController::class, 'viewCategoryTypeProduct'])->name('index');
});
Route::group(['prefix' => 'product-category', 'as' => 'product_category.'], function () {
    Route::get('/{category}', [CategoryController::class, 'viewProductCategory'])->name('index');
});
