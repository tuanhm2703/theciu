<?php

use App\Http\Controllers\Api\CategoryController;

Route::group(['prefix' => 'categories', 'as' => 'category.'], function () {
    Route::get('/getAll', [CategoryController::class, 'getAll']);
});
