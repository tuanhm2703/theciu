<?php

use App\Http\Controllers\Admin\CategoryController;


Route::group(['prefix' => 'category', 'as' => 'category.'], function() {
    Route::get('/product', [CategoryController::class, 'productCategories'])->name('type');
    Route::get('/product/create', [CategoryController::class, 'createProductCategory'])->name('product.create');
    Route::get('/product/{category}/edit', [CategoryController::class, 'editProductCategory'])->name('product.edit');
});
Route::resource('category', CategoryController::class);
