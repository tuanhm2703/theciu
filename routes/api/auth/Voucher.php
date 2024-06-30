<?php

use App\Http\Controllers\Api\Auth\VoucherController;

Route::group(['prefix' => 'vouchers'], function () {
    Route::get('/', [VoucherController::class, 'all']);
    Route::post('/{voucher}/save', [VoucherController::class, 'saveVoucher'])->middleware(['middleware' => 'clientAuth']);
    Route::get('cartVouchers', [VoucherController::class, 'getCartVoucher']);
});
