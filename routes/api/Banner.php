<?php

use App\Http\Controllers\Api\BannerController;

Route::get('/', [BannerController::class, 'getAll'])->name('all');
