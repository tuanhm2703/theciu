<?php

use App\Http\Controllers\Admin\LoginController;

Route::post('logout', [LoginController::class, 'logout'])->name('logout');
