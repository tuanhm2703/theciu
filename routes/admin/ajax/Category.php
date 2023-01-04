<?php

use App\Http\Controllers\Admin\Ajax\CategoryController;


Route::group(['prefix' => 'category', 'as' => 'category.'], function() {
    Route::get('/', [CategoryController::class, 'getAllCategories'])->name('all');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
    Route::get('/{category}/views/product', [CategoryController::class, 'viewAddProduct'])->name('view.add_product');
    Route::post('/{category}/product', [CategoryController::class, 'addProduct'])->name('product.add');
    Route::get('/paginate', [CategoryController::class, 'paginate'])->name('paginate');
    Route::get('/product/paginate', [CategoryController::class, 'paginateProductCategory'])->name('product.paginate');
    Route::get('/search', [CategoryController::class, 'ajaxSearch'])->name('search');
    Route::get('/views/create', [CategoryController::class, 'viewCreate'])->name('view.create');
});
