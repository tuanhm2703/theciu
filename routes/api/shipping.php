<?php

use App\Http\Controllers\Api\Auth\CartController;

Route::get('shipping-info', [CartController::class, 'getShippingInfo']);
