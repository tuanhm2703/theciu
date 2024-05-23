<?php

use App\Http\Controllers\Api\VoucherController;

Route::group(['prefix' => 'vouchers', 'as' => 'voucher.'], function() {
    Route::get('/', [VoucherController::class, 'getAll'])->name('all');
});
