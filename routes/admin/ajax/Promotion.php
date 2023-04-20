<?php

use App\Http\Controllers\Admin\Ajax\PromotionController;

Route::group(['prefix' => 'promotion', 'as' => 'promotion.'], function() {
    include('Promotion/Voucher.php');
    include('Promotion/Product.php');
    Route::get('/paginate', [PromotionController::class, 'paginate'])->name('paginate');
    Route::get('/views/product', [PromotionController::class, 'viewListProduct'])->name('view.product');
    Route::put('/{promotion}', [PromotionController::class, 'updateStatus'])->name('update.status');
    Route::patch('/{voucher}/update-status', [PromotionController::class, 'updateStatus'])->name('voucher.update.status');
});
