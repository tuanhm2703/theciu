<?php

namespace App\Http\Controllers;

use App\Http\Services\Momo\MomoService;
use App\Http\Services\Shipping\GHTKService;
use App\Models\Inventory;
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

    public function test(Request $request) {
        $body = MomoService::checkout(Order::first());
        return redirect($body);
        // return redirect()->to($body->payUrl);
        // return response()->json([
        //     'message' => 'success'
        // ], 204);
    }

    public function ship() {
        return $this->shipping_service->getListPickupTime();
    }

    public function refundMomo() {
        return  MomoService::refund();
    }
}
