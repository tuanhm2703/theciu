<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = parent::toArray($request);
        $result['created_by'] = $this->author_name ?? $this->creator?->full_name;
        $result['image'] = $this->thumbnail ? ['path_with_domain' => $this->thumbnail] : $this->image;
        return $result;
    }
}
