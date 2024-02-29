<?php

use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\VoucherController;

Route::get('/', [VoucherController::class, 'getAll'])->name('all');
