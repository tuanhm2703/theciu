<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderInventoryListResource extends JsonResource
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
            'name' => $this->pivot->name,
            'quantity' => $this->pivot->quantity,
            'origin_price' => $this->pivot->origin_price,
            'promotion_price' => $this->pivot->promotion_price,
            'total' => $this->pivot->total,
            'image' => $this->image?->path_with_domain,
            'attributes' => InventoryAttributeResource::collection($this->attributes)
        ];
    }
}
