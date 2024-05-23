<?php

use App\Http\Controllers\Api\ProductController;

Route::group(['prefix' => 'products', 'as' => 'product.'], function() {
    Route::get('paginate', [ProductController::class, 'paginate'])->name('paginate');
    Route::get('search', [ProductController::class, 'search'])->name('search');
    Route::get('{slug}', [ProductController::class, 'details'])->name('details');
    Route::get('{slug}/related', [ProductController::class, 'relatedProducts'])->name('relatedProducts');
});
