<?php

namespace App\Http\Controllers;

use App\Http\Services\Shipping\GHTKService;
use App\Mail\FirstTestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller {
    private $shipping_service;
    public function __construct(GHTKService $shipping_service) {
        $this->shipping_service =  $shipping_service;
    }

    public function test(Request $request) {
        return dd(Mail::to('tuanhm.work@gmail.com’')->send(new FirstTestMail()));
    }

    public function ipn(Request $request) {
    }

    public function ship() {
        return $this->shipping_service->getListPickupTime();
    }

    public function refundMomo() {
        // return  MomoService::refund();
    }
}
