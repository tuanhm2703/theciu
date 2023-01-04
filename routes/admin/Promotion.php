<?php

use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\VoucherController;

Route::resource('promotion', PromotionController::class);

Route::group(['prefix' => 'promotion', 'as' => 'promotion.'], function() {
    include('promotion/Voucher.php');
});
