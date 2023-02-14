<?php

namespace App\Http\Controllers;

use App\Events\ProductCreated;
use App\Http\Services\Momo\MomoService;
use App\Http\Services\Shipping\GHTKService;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use MService\Payment\AllInOne\Processors\CaptureIPN;
use MService\Payment\AllInOne\Processors\CaptureMoMo;
use MService\Payment\AllInOne\Processors\PayATM;
use MService\Payment\AllInOne\Processors\QueryStatusTransaction;
use MService\Payment\AllInOne\Processors\RefundMoMo;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Collection\InventoryCollection;
use VienThuong\KiotVietClient\Resource\ProductResource;
use VienThuong\KiotVietClient\Resource\WebhookResource;
use VienThuong\KiotVietClient\WebhookType;

class TestController extends Controller {
    private $shipping_service;
    public function __construct(GHTKService $shipping_service) {
        $this->shipping_service =  $shipping_service;
    }

    public function test(Request $request) {
        $client = App::make(Client::class);
        $productResource = new ProductResource($client);
        $product = $productResource->getByCode('SP080974');
        $inventories = $product->getInventories()->getItems();
        foreach($inventories as $inventory) {
            if($inventory->getBranchId() == 392885) {
                $inventory->setOnHand(0);
            }
        }
        $product->setInventories(new InventoryCollection($inventories));
        // dd($productResource->update($product));
        // return dd($productResource->getByCode('SP080974')->getInventories()->getItems());
        $webhookResource = new WebhookResource($client);
        // return $webhookResource->registerWebhook(WebhookType::STOCK_UPDATE, 'https://f4b1-14-187-167-156.ap.ngrok.io/webhook/warehouse/kiotviet', true, 'The ciu cập nhật tồn kho')->getModelData();
        // return $webhookResource->removeWebhook(500122358);
        return $webhookResource->listWebhook()->toArray();
    }

    public function ship() {
        return $this->shipping_service->getListPickupTime();
    }

    public function refundMomo() {
        // return  MomoService::refund();
    }
}
