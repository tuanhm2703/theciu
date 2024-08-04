<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\InventoryResource;
use App\Models\AttributeInventory;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    private ?Inventory $inventory = null;
    public function setInventory(Inventory $inventory) {
        $this->inventory = $inventory;
        return $this;
    }
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'promotion_price' => $this->promotion_price,
            'sale_price' => $this->sale_price,
            'discount_percent' => $this->discount_percent,
            'slug' => $this->slug,
            'is_main_product' => (boolean) $this->pivot?->featured,
            'selected_inventory_id' => $this->inventory?->id,
            'is_selected' => (boolean) $this->inventory?->pivot?->is_selected,
            'selected_quantity' => $this->inventory?->pivot?->quantity ?? 1,
            'inventories' => InventoryResource::collection($this->inventories),
            'attributes' => $this->getAttributes($this->inventories->first()->attributes->first())
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
}
