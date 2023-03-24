<?php

use App\Http\Controllers\Admin\VoucherController;

Route::group(['prefix' => 'voucher', 'as' => 'voucher.'], function () {
    Route::get('/{voucher}/quick-view', [VoucherController::class, 'quickView'])->name('quickview');
});
Route::resource('voucher', VoucherController::class);
