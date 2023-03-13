<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Setting;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\BranchResource;
use VienThuong\KiotVietClient\Resource\SaleChannelResource;
use VienThuong\KiotVietClient\Resource\WebhookResource;
use VienThuong\KiotVietClient\WebhookType;

class SyncWarehouseController extends Controller {
    public function index() {
        $brancheResource = new BranchResource(App::make(Client::class));
        $branches = $brancheResource->list()->toArray();
        $branches = collect($branches);
        $saleChannelResource = new SaleChannelResource(App::make(Client::class));
        $sale_channels = $saleChannelResource->list()->toArray();
        foreach($sale_channels as $index => $channel) {
            $sale_channels[$index]['name'] = $channel['name']. "|". $channel['otherProperties']['img'];
        }
        $sale_channels = collect($sale_channels);
        $kiotSetting = App::get('KiotConfig');
        if(isset($kiotSetting->data['saleChannelId'])) {
            foreach($sale_channels as $channel) {

            }
        }
        $numberOfProductHaveToSync = Inventory::whereNotNull('sku')->count();
        return view('admin.pages.setting.warehouse.index', compact('branches', 'kiotSetting', 'numberOfProductHaveToSync', 'sale_channels'));
    }

    public function update(Request $request) {
        $data = $request->all();
        $kiotSetting = Setting::firstOrCreate([
            'name' => 'kiotviet_config'
        ]);
        $kiotSetting->data = $data;
        $kiotSetting->save();
        $client = App::make(Client::class);
        $webhookResource = new WebhookResource($client);
        try {
            $webhooklist = $webhookResource->list()->toArray();
            foreach($webhooklist as $webhook) {
                if($webhook['otherProperties']['type'] == WebhookType::STOCK_UPDATE && $webhook['otherProperties']['isActive'] == false) {
                    $webhookResource->remove($webhook['id']);
                }
                $webhookResource->registerWebhook(WebhookType::STOCK_UPDATE, route('webhook.warehouse.kiotviet'), true, 'The CIU cập nhật tồn kho');
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
        return BaseResponse::success([
            'message' => 'Cập nhật cấu hình KiotViet thành công'
        ]);
    }

    public function syncStock(Request $request) {
        $pageSize = $request->pageSize ?? 10;
        $inventories = Inventory::whereNotNull('sku')->paginate($pageSize);
        foreach ($inventories as $inventory) {
            try {
                $inventory->syncKiotWarehouse();
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        return BaseResponse::success([
            'message' => 'Sync thành công'
        ]);
    }
}
