<?php

namespace App\Http\Controllers;

use App\Http\Services\Shipping\GHTKService;
use App\Jobs\ResizeImageJob;
use App\Mail\FirstTestMail;
use App\Models\Customer;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Model\CustomerGroup;
use VienThuong\KiotVietClient\Resource\CustomerResource;
use VienThuong\KiotVietClient\Resource\InvoiceResource;
use VienThuong\KiotVietClient\Resource\OrderResource;
use VienThuong\KiotVietClient\Resource\ProductResource;

class TestController extends Controller {
    private $shipping_service;
    public function __construct(GHTKService $shipping_service) {
        $this->shipping_service =  $shipping_service;
    }

    public function test(Request $request) {
        $orderResource = new OrderResource(App::make(Client::class));
        return $orderResource->getByCode('DH000620')->getModelData();
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
