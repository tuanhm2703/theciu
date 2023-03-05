<?php

namespace App\Http\Controllers;

use App\Http\Services\Momo\MomoService;
use App\Http\Services\Shipping\GHTKService;
use App\Http\Services\VNPay\src\Models\CreatePaymentRequest;
use App\Http\Services\VNPay\src\Models\IPNUrl;
use App\Http\Services\VNPay\src\Models\VNPayment;
use App\Http\Services\VNPay\src\Models\VNRefund;
use App\Models\Order;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\CustomerResource;
use VienThuong\KiotVietClient\Resource\OrderResource;
use VienThuong\KiotVietClient\Resource\ProductResource;
use VienThuong\KiotVietClient\Resource\WebhookResource;

class TestController extends Controller {
    private $shipping_service;
    public function __construct(GHTKService $shipping_service) {
        $this->shipping_service =  $shipping_service;
    }

    public function test(Request $request) {
        $customerResource = new CustomerResource(App::make(Client::class));
        return dd($customerResource->list(['contactNumber' => '0328483487']));
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
