<?php

namespace App\Http\Resources\Api;

use App\Http\Services\Promotion\PromotionService;
use App\Http\Services\Voucher\VoucherService;
use App\Models\Voucher;
use Illuminate\Http\Resources\Json\JsonResource;

class CartGeneralResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    static $products;
    static $order_voucher_id;
    static $freeship_voucher_id;
    public function toArray($request) {
        $promotionService = new PromotionService;
        $accom_gift_promotions = $promotionService->getAvailableAccomGiftPromotionsForCart();
        $accom_product_promotions = $promotionService->getAvailableAccomProductPromotionsForCart();
        $combos = $promotionService->getAvailableCombo();
        $total = $this->getTotalWithSelectedItemsV2($this->inventories->where('pivot.is_selected', true)->pluck('id')->toArray());
        return [
            'products' => $this->getSelectedItemsInfo(),
            'total' => $total,
            'accom_gift_promotion' => CartPromotionResource::collection($accom_gift_promotions),
            'accom_product' => CartPromotionResource::collection($accom_product_promotions),
            'combo' => CartComboResource::collection($combos),
            'vouchers' => (new VoucherService)->getUserCartVoucherResource(requestUser(), $this->inventories->pluck('id')->toArray()),
            'combo_discount' => $this->calculateComboDiscount($combos)
        ];
    }
    private function calculateComboDiscount($combos) {
        $total = 0;
        foreach($combos as $combo) {
            $product_ids = $combo->products->pluck('id')->toArray();
            if(count($this->inventories->whereIn('product_id', $product_ids)->unique('product_id')->pluck('product_id')->toArray()) === count($product_ids)) {
                foreach($this->inventories->whereIn('product_id', $product_ids) as $inventory) {
                    $total += $inventory->price - $inventory->sale_price;
                }
            }
        }
        return $total;
    }
    private function getSelectedItemsInfo() {
        $results = [];
        $inventories = $this->inventories;
        foreach($inventories as $inventory) {
            $inventory->product->load('inventories.image', 'inventories.attributes');
            if($inventory->product->inventories->count() > 0) {
                $results[] = (new CartProductDetailResource($inventory->product))->setInventory($inventory);
            }
        }
        return $results;
    }
}
