<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartPromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'promotion' => $this->promotion,
            'min_order_value' => $this->min_order_value,
            'type' => $this->type,
            'products' => CartProductDetailResource::collection($this->products)
        ];
    }
}
