<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'open_time' => $this->open_time,
            'close_time' => $this->close_time,
            'google_latitude' => $this->google_latitude,
            'google_longitude' => $this->google_longitude,
            'phone' => $this->phone,
            'email' => $this->email,
            'is_open' => $this->is_open,
            'address' => $this->address?->full_address,
            'image' => $this->image?->path_with_domain
        ];
    }
}
