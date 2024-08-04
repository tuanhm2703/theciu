<?php

namespace App\Http\Resources\Api;

use App\Http\Services\Promotion\PromotionService;
use App\Http\Services\Voucher\VoucherService;
use Illuminate\Http\Resources\Json\JsonResource;

class CartGeneralResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    static $products;
    public function toArray($request) {
        $promotionService = new PromotionService;
        $accom_gift_promotions = $promotionService->getAvailableAccomGiftPromotionsForCart();
        $accom_product_promotions = $promotionService->getAvailableAccomProductPromotionsForCart();
        $combos = $promotionService->getAvailableCombo();
        return [
            'products' => $this->getSelectedItemsInfo(),
            'total' => $this->getTotalWithSelectedItems($this->inventories->where('pivot.is_selected', true)->pluck('id')->toArray()),
            'accom_gift_promotion' => CartPromotionResource::collection($accom_gift_promotions),
            'accom_product' => CartPromotionResource::collection($accom_product_promotions),
            'combo' => CartComboResource::collection($combos),
            'vouchers' => (new VoucherService)->getUserCartVoucherResource(requestUser(), $this->inventories->pluck('id')->toArray())
        ];
    }

    private function getSelectedItemsInfo() {
        $results = [];
        $inventories = $this->inventories;
        foreach($inventories as $inventory) {
            $inventory->product->load('inventories.image', 'inventories.attributes');
            $results[] = (new CartProductDetailResource($inventory->product))->setInventory($inventory);
        }
        return $results;
    }
}
