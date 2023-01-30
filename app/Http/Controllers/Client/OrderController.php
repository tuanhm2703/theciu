<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index() {
        $orders = auth('customer')->user()->orders()->with('inventories.image')->get();
        return view('landingpage.layouts.pages.order.index', compact('orders'));
    }

    public function pay() {

    }
}
