<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CartInventoryResource extends JsonResource
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
            'quantity' => $this->pivot->quantity,
            'price' => $this->price,
            'quantity_each_order' => $this->quantity_each_order,
            'promotion_price' => $this->has_promotion ? $this->promotion_price : 0,
            'attributes' => InventoryAttributeResource::collection($this->attributes)
        ];
    }
}
