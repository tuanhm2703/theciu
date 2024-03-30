<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        $this->getMetaTags();
        return [
            'name' => $this->name,
            'lazy_image' => $this->image?->product_lazy_load_path,
            'flash_sales' => $this->available_flash_sales,
            'promotion_price' => $this->promotion_price,
            'sale_price' => $this->sale_price,
            'liked' => false,
            'discount_percent' => $this->discount_percent,
            'is_new' => now()->diffInDays($this->created_at, true) <= 3,
            'slug' => $this->slug,
            'description' => $this->description,
            'model' => $this->model,
            'material' => $this->material,
            'style' => $this->style,
            'type' => $this->type,
            'is_reorder' => (bool) $this->is_reorder,
            'condition' => $this->condition,
            'sku' => $this->sku,
            'short_description' => $this->short_description,
            'additional_information' => $this->additional_information,
            'shipping_and_return' => $this->shipping_and_return,
            'code' => $this->code,
            'images' => $this->images->pluck('path_with_domain')->toArray(),
            'inventories' => InventoryResource::collection($this->inventories),
            'first_attribute' => new AttributeResource($this->firstAttribute()),
            'second_attribute' => new AttributeResource($this->secondAttribute()),
            'meta' => \Meta::tags()
        ];
    }

    private function firstAttribute() {
        return $this->inventories->first()->firstAttribute()->with(['inventories' => function ($q) {
            $q->where('inventories.product_id', $this->id);
        }, 'inventories.image'])->first();
    }
    private function secondAttribute() {
        return $this->inventories->first()->secondAttribute()->with(['inventories' => function ($q) {
            $q->where('inventories.product_id', $this->id);
        }, 'inventories.image'])->first();
    }
}
