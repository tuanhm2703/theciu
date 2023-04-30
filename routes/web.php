<?php

use App\Http\Controllers\Admin\Ajax\AttributeController;
use App\Http\Controllers\Admin\Ajax\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\TestController;
use App\Http\Livewire\AddressSelectComponent;

Route::group(['prefix' => 'admintheciu', 'as' => 'admin.'], function() {
    include('admin/Auth.php');
    Route::get('/', [HomeController::class, 'welcome'])->name('welcome')->middleware('auth');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
        Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
        include('admin/Profile.php');
        include('admin/Module.php');
        Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
        Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
        Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
        include('admin/auth/Auth.php');
        include('admin/Product.php');
        include('admin/Category.php');
        include('admin/Promotion.php');
        include('admin/Appearance.php');
        include('admin/Setting.php');
        include('admin/Order.php');
        include('admin/Page.php');
        include('admin/Customer.php');
        include('admin/Rank.php');
        Route::get('/{page}', [PageController::class, 'index'])->name('page');
        Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function() {
            include('admin/ajax/Category.php');
            include('admin/ajax/Attribute.php');
            include('admin/ajax/Product.php');
            include('admin/ajax/Module.php');
            include('admin/ajax/Promotion.php');
            include('admin/ajax/Appearance.php');
            include('admin/ajax/Image.php');
            include('admin/ajax/Order.php');
            include('admin/ajax/Page.php');
        });
    });
});

include('client/Client.php');
include('Webhook.php');

Route::get('test', [TestController::class, 'test']);
Route::get('test-ipn', [TestController::class, 'ipn']);
