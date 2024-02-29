<?php

use App\Http\Controllers\Api\ProductController;

Route::get('paginate', [ProductController::class, 'paginate'])->name('paginate');
