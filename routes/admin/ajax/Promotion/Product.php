<?php

use App\Http\Controllers\Admin\PromotionController;

Route::group(['prefix' => 'product', 'as' => 'product.'], function() {
    Route::get('/paginate', [PromotionController::class, 'paginateProduct'])->name('paginate');
    Route::get('/with-inventories', [PromotionController::class, 'getProductWithInventories'])->name('with_inventories');
});
