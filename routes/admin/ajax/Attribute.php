<?php

use App\Http\Controllers\Admin\Ajax\AttributeController;

Route::get('attributes/search', [AttributeController::class, 'ajaxSearch'])->name('attribute.search');
