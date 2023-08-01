<?php

use App\Http\Controllers\Admin\ReviewController;

Route::group(['prefix' => 'review', 'as' => 'review.'], function() {
    Route::get('index', [ReviewController::class, 'index'])->name('index');
    Route::get('paginate', [ReviewController::class, 'paginate'])->name('paginate');
    Route::get('{review}/reply', [ReviewController::class, 'replyForm'])->name('reply.edit');
    Route::put('{review}/reply', [ReviewController::class, 'replyReview'])->name('reply.update');
    Route::put('{review}/active', [ReviewController::class, 'active'])->name('active');
    Route::put('{review}/deactive', [ReviewController::class, 'deactive'])->name('deactive');
    Route::get('setting/voucher', [ReviewController::class, 'settingVoucher'])->name('setting.voucher');
    Route::get('voucher/paginate', [ReviewController::class, 'vouchers'])->name('voucher.paginate');
    Route::post('setting/voucher', [ReviewController::class, 'chooseVoucherforReview'])->name('setting.voucher.update');
    Route::delete('setting/voucher', [ReviewController::class, 'deleteVoucherForReview'])->name('setting.voucher.delete');
});
