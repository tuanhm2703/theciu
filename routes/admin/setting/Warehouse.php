<?php

use App\Http\Controllers\Admin\SyncWarehouseController;

Route::group(['prefix' => 'warehouse', 'as' => 'warehouse.'], function() {
    Route::get('/', [SyncWarehouseController::class, 'index'])->name('index');
    Route::put('/update', [SyncWarehouseController::class, 'update'])->name('update');
    Route::post('/stock/sync', [SyncWarehouseController::class, 'syncStock'])->name('stock.sync');
});
