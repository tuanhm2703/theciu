<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class WarehouseWebhookController extends Controller {
    public function updateKiotProduct(Request $request) {
        try {
            $data = $request->Notifications[0]['Data'][0];
            $sku = $data['ProductCode'];
            $inventory = Inventory::whereSku($sku)->firstOrFail();
            $kiotConfig = App::get('KiotConfig');
            if($inventory->sku == $sku && $kiotConfig->data['branchId'] == $data['branchId']) {
                $inventory->stock_quantity = $data['OnHand'];
                $inventory->status = $data['isActive'];
                $inventory->save();
            }
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
        }
        return response()->json([
            'message' => 'Success'
        ]);
    }
}
