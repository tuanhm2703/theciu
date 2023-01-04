<?php

use App\Http\Controllers\Admin\Ajax\ProductController;

Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
    Route::get('paginate', [ProductController::class, 'paginate'])->name('paginate');
    Route::get('/{product}/inventories', [ProductController::class, 'getInventories'])->name('inventories');
    Route::get('/details-value', [ProductController::class, 'ajaxSearchDetailsInfoAttribute'])->name('detail_value');
    Route::post('/create-from-file', [ProductController::class, 'createFromFile'])->name('create_from_file');
    Route::get('/views/batch-create', [ProductController::class, 'loadBatchCreateView'])->name('views.batch_create');
    Route::get('/views/batch-update', [ProductController::class, 'loadBatchUpdateView'])->name('views.batch_update');
    Route::get('/batch-file', [ProductController::class, 'downloadBatchUpdateFile'])->name('batch_action.file');
    Route::post('/batch-update', [ProductController::class, 'batchUpdateFromFile'])->name('batch_action.update');
});
