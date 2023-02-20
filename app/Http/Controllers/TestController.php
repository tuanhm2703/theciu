<?php

namespace App\Http\Controllers;

use App\Http\Services\Shipping\GHTKService;
use App\Http\Services\VNPay\src\Models\CreatePaymentRequest;
use App\Http\Services\VNPay\src\Models\IPNUrl;
use App\Http\Services\VNPay\src\Models\VNPayment;
use Illuminate\Http\Request;

class TestController extends Controller {
    private $shipping_service;
    public function __construct(GHTKService $shipping_service) {
        $this->shipping_service =  $shipping_service;
    }

    public function test(Request $request) {
        return redirect()->to(VNPayment::process(time(),30000000, 'don hang theciu', 'http://localhost:4000/test-ipn'));
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
