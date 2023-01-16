<?php

namespace App\Http\Controllers;

use App\Http\Services\Momo\MomoService;
use App\Http\Services\Shipping\GHTKService;
use App\Models\Order;
use Illuminate\Http\Request;
use MService\Payment\AllInOne\Processors\CaptureIPN;
use MService\Payment\AllInOne\Processors\CaptureMoMo;
use MService\Payment\AllInOne\Processors\PayATM;
use MService\Payment\AllInOne\Processors\QueryStatusTransaction;
use MService\Payment\AllInOne\Processors\RefundMoMo;

class TestController extends Controller {
    private $shipping_service;
    public function __construct(GHTKService $shipping_service) {
        $this->shipping_service =  $shipping_service;
    }

    public function test() {
        $env = MomoService::selectEnv('dev');
        $orderId = time() . "";
        $requestId = time() . "";
        $partnerCode = env('DEV_PARTNER_CODE');
        $accessKey = env('DEV_ACCESS_KEY');
        // dd(CaptureIPN::process($env, $data));
        dd(MomoService::checkout(Order::latest()->first()));
    }

    public function ship() {
        return $this->shipping_service->getListPickupTime();
    }
}
