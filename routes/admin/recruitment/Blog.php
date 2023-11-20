<?php

use App\Http\Controllers\Admin\BlogController;

Route::group(['prefix' => 'blog', 'as' => 'blog.'], function() {
    Route::get('/', [BlogController::class, 'recruitmentBlog'])->name('index');
});
