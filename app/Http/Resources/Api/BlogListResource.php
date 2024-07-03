<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            "title" => $this->title,
            "description" => $this->description,
            "publish_date" => $this->publish_date,
            "image" => $this->thumbnail ?? $this->image?->path_with_domain,
            "slug" => $this->slug,
            'id' => $this->id,
            'categories' => $this->categories->select('name', 'id', 'slug')->toArray()
        ];
    }
}
