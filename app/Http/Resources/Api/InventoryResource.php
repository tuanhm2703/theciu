<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'image' => $this->image?->path_with_domain,
            'stock_quantity' => $this->stock_quantity,
            'price' => $this->price,
            'promotion_price' => $this->has_promotion && $this->promotion_status ? $this->promotion_price : null,
            'attributes' => InventoryAttributeResource::collection($this->attributes)
        ];
    }
}
