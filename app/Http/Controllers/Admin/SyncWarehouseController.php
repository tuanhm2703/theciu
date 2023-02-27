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
use VienThuong\KiotVietClient\Resource\WebhookResource;
use VienThuong\KiotVietClient\WebhookType;

class SyncWarehouseController extends Controller {
    public function index() {
        $brancheResource = new BranchResource(App::make(Client::class));
        $branches = $brancheResource->list()->toArray();
        $branches = collect($branches);
        $kiotSetting = App::get('KiotConfig');
        $numberOfProductHaveToSync = Product::whereNotNull('sku')->count();
        return view('admin.pages.setting.warehouse.index', compact('branches', 'kiotSetting', 'numberOfProductHaveToSync'));
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
            $webhookResource->registerWebhook(WebhookType::STOCK_UPDATE, route('webhook.warehouse.kiotviet'), true, 'The CIU cập nhật tồn kho');
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
