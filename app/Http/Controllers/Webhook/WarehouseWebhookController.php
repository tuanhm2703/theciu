<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class WarehouseWebhookController extends Controller {
    public function updateKiotProduct(Request $request) {
        try {
            $sku = $request->Notifications[0]['Data'][0]['ProductCode'];
            $product = Product::whereSku($sku)->firstOrFail();
            $product->syncKiotWarehouse();
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
        }
        return response()->json([
            'message' => 'Success'
        ]);
    }
}
