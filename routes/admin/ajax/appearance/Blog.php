<?php

use App\Http\Controllers\Admin\Ajax\BlogController;

Route::group(['prefix' => 'blog', 'as' => 'blog.'], function() {
    Route::get('paginate', [BlogController::class, 'paginate'])->name('paginate');
});
