<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\BranchResource;

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
        return BaseResponse::success([
            'message' => 'Cập nhật cấu hình KiotViet thành công'
        ]);
    }

    public function syncStock(Request $request) {
        $pageSize = $request->pageSize ?? 10;
        $products = Product::whereNotNull('sku')->paginate($pageSize);
        foreach ($products as $product) {
            try {
                $product->syncKiotWarehouse();
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        return BaseResponse::success([
            'message' => 'Sync thành công'
        ]);
    }
}
