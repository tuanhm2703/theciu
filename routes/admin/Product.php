<?php

use App\Http\Controllers\Admin\ProductController;

Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
    Route::delete('mass', [ProductController::class, 'massDelete'])->name('delete.mass');
});
Route::resource('product', ProductController::class);
