<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionDetailResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'slug' => $this->slug,
            'content' => $this->content,
            'image' => $this->image?->path_with_domain,
            'products' => ProductResource::collection($this->products)
        ];
    }
}
