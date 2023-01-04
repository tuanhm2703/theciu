<?php

use App\Http\Controllers\Admin\BlogController;

Route::resource('blog', BlogController::class);
Route::group(['prefix' => 'blog', 'as' => 'blog.'], function() {

});
