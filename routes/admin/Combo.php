<?php

use App\Http\Controllers\Admin\ComboController;

Route::group(['prefix' => 'combo', 'as' => 'combo.'], function() {
    Route::get('/', [ComboController::class, 'index'])->name('index');
    Route::get('create', [ComboController::class, 'create'])->name('create');
    Route::get('{id}/edit', [ComboController::class, 'edit'])->name('edit');
    Route::post('/', [ComboController::class, 'store'])->name('store');
    Route::put('/{combo}', [ComboController::class, 'update'])->name('update');
    Route::delete('/{combo}', [ComboController::class, 'destroy'])->name('destroy');
    Route::put('{combo}/status', [ComboController::class, 'updateStatus'])->name('update.status');
    Route::get('modal/product', [ComboController::class, 'viewProductListModal'])->name('modal.product');
    Route::get('paginate', [ComboController::class, 'paginate'])->name('paginate');
});
