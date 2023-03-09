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
use VienThuong\KiotVietClient\Collection\OrderDetailCollection;
use VienThuong\KiotVietClient\Model\Order as ModelOrder;
use VienThuong\KiotVietClient\Model\OrderDetail;
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
        $productResource = new ProductResource(App::make(Client::class));
        $orderResource = new OrderResource(App::make(Client::class));
        // return $orderResource->list(['pageSize' => 100, 'orderBy' => 'CreatedDate', 'orderDirection' => 'DESC'])->toArray();
        // $order = $orderResource->getByCode('DH000013');
        // $order->setMethod('hello');
        // dd($orderResource->update($order));
        $kiotSetting = App::get('KiotConfig');
        $ciuOrder = Order::first();
        $order = new ModelOrder();
        $order->setPurchaseDate(now());
        $order->setBranchId($kiotSetting->data['branchId']);
        $order->setDescription('The ciu order');
        $order->setTotalPayment($ciuOrder->total);
        $order->setMethod('hello');
        $order->setOrderDetails(new OrderDetailCollection([
            new OrderDetail([
                'productCode' => 'test',
                'quantity' => 1
            ])
        ]));
        dd($orderResource->create($order));

        return dd($productResource->getByCode('test'));
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
