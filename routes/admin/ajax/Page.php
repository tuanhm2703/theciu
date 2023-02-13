<?php

use App\Http\Controllers\Admin\Ajax\PageController;

Route::group(['prefix' => 'page', 'as' => 'page.'], function() {
    Route::get('paginate', [PageController::class, 'paginate'])->name('paginate');
});
