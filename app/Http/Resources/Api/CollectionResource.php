<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource {
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
            'created_at' => $this->created_at,
            'likes' => $this->wishlists_count,
            'short_description' => $this->short_description
        ];
    }
}
