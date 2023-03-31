<?php

namespace App\Http\Controllers;

use App\Http\Services\Shipping\GHTKService;
use App\Mail\FirstTestMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Model\CustomerGroup;
use VienThuong\KiotVietClient\Resource\CustomerResource;
use VienThuong\KiotVietClient\Resource\ProductResource;

class TestController extends Controller {
    private $shipping_service;
    public function __construct(GHTKService $shipping_service) {
        $this->shipping_service =  $shipping_service;
    }

    public function test(Request $request) {
        $customers = Customer::all();
        $customers->each(function($customer) {
            $customer->updateRank();
        });
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
