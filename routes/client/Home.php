<?php

use App\Http\Controllers\Client\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('cacheResponse:300');
Route::get('/about', [HomeController::class, 'about'])->name('about');
