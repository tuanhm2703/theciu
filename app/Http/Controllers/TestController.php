<?php

namespace App\Http\Controllers;

use App\Http\Services\Shipping\GHTKService;
use App\Mail\FirstTestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\CustomerResource;
use VienThuong\KiotVietClient\Resource\ProductResource;

class TestController extends Controller {
    private $shipping_service;
    public function __construct(GHTKService $shipping_service) {
        $this->shipping_service =  $shipping_service;
    }

    public function test(Request $request) {
        $productResource = new ProductResource(App::make(Client::class));
        $customerResource = new CustomerResource(App::make(Client::class));
        return $customerResource->list()->toArray();
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
