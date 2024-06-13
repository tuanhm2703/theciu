<?php

namespace App\Http\Resources\Api;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image?->path_with_domain,
            'lazy_image' => $this->image?->product_lazy_load_path,
            'flash_sales' => $this->available_flash_sales,
            'promotion_price' => $this->promotion_price,
            'sale_price' => $this->sale_price,
            'liked' => false,
            'discount_percent' => $this->discount_percent,
            'images' => $this->getInventoryImages(),
            'is_new' => now()->diffInDays($this->created_at, true) <= 3,
            'slug' => $this->slug
        ];
    }

    private function getInventoryImages() {
        $arr = [];
        foreach($this->inventories as $inventory) {
            $arr[] = $inventory->image?->getPathWithSize(100);
        }
        return array_unique($arr);
    }
}
