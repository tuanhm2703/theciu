<?php

use App\Http\Controllers\Client\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
