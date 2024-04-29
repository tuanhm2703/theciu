<?php

namespace App\Http\Resources\Api;

use App\Models\AttributeInventory;
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
            'size_image' => $this->size_rule_image?->path_with_domain,
            'attributes' => $this->getAttributes($this->inventories->first()->attributes->first()),
            'meta' => \Meta::tags()
        ];
    }
    private function getAttributes($attribute) {
        $values = AttributeInventory::whereIn('inventory_id', $this->inventories->pluck('id')->toArray())->where('attribute_id', $attribute->id)->get()->unique('value');
        $results = [];
        foreach ($values as $value) {
            $results[] = [
                'id' => $value->attribute_id,
                'value' => $value->value,
                'name' => $attribute->name,
                'image' => $this->inventories->where('id', $value->inventory_id)->first()?->image?->path_with_domain,
                'small_image' => $this->inventories->where('id', $value->inventory_id)->first()?->image?->getPathWithSize(100),
                'stock_quantity' => $this->calculateStock($this->inventories, $attribute->id, $value->value),
                'children' => $this->getChildrenAttributes($attribute, $value->value)
            ];
        }
        return $results;
    }

    private function getChildrenAttributes($attribute, $attribute_value) {
        $child_attribute = $this->inventories->first()->attributes->where('id', '!=', $attribute->id)->first();
        if(!$child_attribute) {
            return [];
        }
        $values = AttributeInventory::whereIn('inventory_id', $this->inventories->pluck('id')->toArray())->where('attribute_id', $child_attribute->id)->get()->unique('value');
        $results = [];
        foreach ($values as $value) {
            $inventories = collect();
            foreach($this->inventories as $inventory) {
                if($inventory->attributes->where('pivot.value', $attribute_value)->first()) $inventories->push($inventory);
            }
            $results[] = [
                'id' => $value->attribute_id,
                'value' => $value->value,
                'name' => $child_attribute->name,
                'image' => $this->inventories->where('id', $value->inventory_id)->first()?->image?->path_with_domain,
                'small_image' => $this->inventories->where('id', $value->inventory_id)->first()?->image?->getPathWithSize(60),
                'stock_quantity' => $this->calculateStock($inventories, $child_attribute->id, $value->value),
            ];
        }
        return $results;
    }

    private function calculateStock($inventories, int $attribute_id, string $value) {
        $sum = 0;
        foreach ($inventories as $inventory) {
            $attributes = $inventory->attributes;
            foreach ($attributes as $attribute) {
                if ($attribute->id === $attribute_id && $attribute->pivot->value === $value) $sum += $inventory->stock_quantity;
            }
        }
        return $sum;
    }

    private function secondAttribute() {
        return $this->inventories->first()->secondAttribute()->with(['inventories' => function ($q) {
            $q->where('inventories.product_id', $this->id);
        }, 'inventories.image'])->first();
    }
}
