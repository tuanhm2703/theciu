<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\CollectionController;
use App\Http\Controllers\Api\Auth\EventController;
use App\Http\Controllers\Api\Auth\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('logout', [AuthController::class, 'logout']);
Route::get('/profile', [AuthController::class, 'profile']);
Route::put('/profile', [AuthController::class, 'updateProfile']);
Route::delete('/profile', [AuthController::class, 'deleteProfile']);
Route::post('/avatar', [AuthController::class, 'updateAvatar']);
Route::delete('/avatar', [AuthController::class, 'deleteAvatar']);
Route::get('/wishlist/product', [ProductController::class, 'getWishlist']);
Route::post('/wishlist/product/{slug}/addToWishlist', [ProductController::class, 'addToWishlist']);
Route::delete('/wishlist/produt/{slug}/removeFromWishlist', [ProductController::class, 'removeFromWishlist']);
Route::get('/wishlist/collection', [CollectionController::class, 'getWishlist']);
Route::post('/wishlist/collection/{slug}/addToWishlist', [CollectionController::class, 'addToWishlist']);
Route::delete('/wishlist/collection/{slug}/removeFromWishlist', [CollectionController::class, 'removeFromWishlist']);
Route::post('events/{slug}/mark', [EventController::class, 'mark']);
Route::delete('events/{slug}/removeMark', [EventController::class, 'removeMark']);
