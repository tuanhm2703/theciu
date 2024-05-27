<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('logout', [AuthController::class, 'logout']);
Route::get('/profile', [AuthController::class, 'profile']);
Route::put('/profile', [AuthController::class, 'updateProfile']);
Route::delete('/profile', [AuthController::class, 'deleteProfile']);
Route::post('/avatar', [AuthController::class, 'updateAvatar']);
Route::delete('/avatar', [AuthController::class, 'deleteAvatar']);
Route::get('/wishlist', [AuthController::class, 'getWishlist']);
Route::post('/wishlist/{slug}/addToWishlist', [AuthController::class, 'addToWishlist']);
Route::delete('/wishlist/{slug}/removeFromWishlist', [AuthController::class, 'removeFromWishlist']);
