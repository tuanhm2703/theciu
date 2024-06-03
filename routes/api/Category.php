<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'categories', 'as' => 'category.'], function () {
    Route::get('/getAll', [CategoryController::class, 'getAll']);
});
