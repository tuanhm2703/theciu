<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'id'=> $this->id,
            'desktop_image' => $this->desktopImage?->path_with_domain,
            'mobile_image' => $this->phoneImage?->path_with_domain,
            'url' => $this->url,
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
