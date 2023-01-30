<?php

namespace App\Http\Controllers;

use App\Http\Services\Shipping\GHTKService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShippingWebhookController extends Controller {
    private GHTKService $shipping_service;
    public function __construct(GHTKService $service) {
        $this->shipping_service = $service;
    }
    public function postWebhook(Request $request, $service_alias) {
        Log::info($request->all());
        DB::beginTransaction();
        try {
            try {
                $this->shipping_service->createShippingOrderHistory($request->all());
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                DB::rollback();
                return response()->json([
                    'message' => $e->getMessage(),
                ], 404);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
