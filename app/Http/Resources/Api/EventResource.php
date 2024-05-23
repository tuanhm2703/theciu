<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'content' => $this->content,
            'image_section' => $this->image_section,
            'image' => $this->image?->path_with_domain,
            'from' => $this->from,
            'to' => $this->to,
            'slug' => $this->slug
        ];
    }
}
