<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function productExchangeAndWarranty() {
        return view('landingpage.layouts.pages.page.product_exchange_and_warranty');
    }

    public function payment() {
        return view('landingpage.layouts.pages.page.payment');
    }
    public function shipment() {
        return view('landingpage.layouts.pages.page.shipment');
    }
    public function about() {
        return view('landingpage.layouts.pages.about.index');
    }
    public function contact() {
        return view('landingpage.layouts.pages.contact.index');
    }
    public function customerService() {
        return view('landingpage.layouts.pages.page.customer_service');
    }

    public function paymentSafety() {
        return view('landingpage.layouts.pages.page.payment_safety');
    }

    public function details($slug) {
        $page = Page::whereSlug($slug)->firstOrFail();
        return view('landingpage.layouts.pages.page.details', compact('page'));
    }
}
