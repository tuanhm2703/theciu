<?php

namespace App\Http\Resources\Api;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerWishlistResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            'product_ids' => $this->query_wishlist(Product::class)->pluck('id')->toArray(),
            'collection_ids' => $this->query_wishlist(Category::class)->pluck('id')->toArray(),
        ];
    }
}
