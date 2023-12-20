<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\KiotProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use VienThuong\KiotVietClient\WebhookType;

class WarehouseWebhookController extends Controller
{
    public function updateKiotProduct(Request $request)
    {
        try {
            $data = $request->Notifications[0]['Data'][0];
            if(isset($request->Notifications[0]["Action"]) && (strpos($request->Notifications[0]["Action"], WebhookType::PRODUCT_DELETE) > -1)) {
                $codes = $request->Notifications[0]['Data'];
                $skus = KiotProduct::whereIn('kiot_product_id', $codes)->pluck('kiot_code')->toArray();
                Inventory::whereIn('sku', $skus)->delete();
            } else {
                $sku = $data['ProductCode'];
                $inventory = Inventory::whereSku($sku)->firstOrFail();
                $kiotConfig = App::get('KiotConfig');
                if ($inventory->sku == $sku && $kiotConfig->data['branchId'] == $data['BranchId']) {
                    $inventory->stock_quantity = $data['OnHand'] - $data['Reserved'];
                    $inventory->stock_quantity = $inventory->stock_quantity < 0 ? 0 : $inventory->stock_quantity;
                    $inventory->status = $data['isActive'];
                    $inventory->save();
                }
            }
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
        }
        return response()->json([
            'message' => 'Success'
        ]);
    }
}
