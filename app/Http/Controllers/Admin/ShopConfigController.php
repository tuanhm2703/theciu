<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopConfigController extends Controller
{
    public function index() {
        return view('admin.pages.setting.shop.index');
    }
}
