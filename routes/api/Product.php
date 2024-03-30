<?php

use App\Http\Controllers\Api\ProductController;

Route::get('paginate', [ProductController::class, 'paginate'])->name('paginate');
Route::get('search', [ProductController::class, 'search'])->name('search');
