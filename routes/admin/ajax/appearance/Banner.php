<?php

use App\Http\Controllers\Admin\Ajax\BannerController;

Route::group(['prefix' => 'banner', 'as' => 'banner.'], function() {
    Route::get('paginate', [BannerController::class, 'paginate'])->name('paginate');
});
