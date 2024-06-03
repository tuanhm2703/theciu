<?php

namespace App\Http\Resources\Api;

use App\Models\Category;
use App\Models\Event;
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
            'product_ids' => $this->get_wishlist_id_list(Product::class),
            'collection_ids' => $this->get_wishlist_id_list(Category::class),
            'event_ids' => $this->get_wishlist_id_list(Event::class),
        ];
    }
}
