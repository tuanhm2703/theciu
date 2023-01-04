<?php

use App\Http\Controllers\Admin\Ajax\VoucherController;

Route::group(['prefix' => 'voucher', 'as' => 'voucher.'], function() {
    Route::get('paginate', [VoucherController::class, 'paginate'])->name('paginate');
});
