<?php

use App\Http\Controllers\Api\CategoryController;

Route::get('/getAll', [CategoryController::class, 'getAll']);
