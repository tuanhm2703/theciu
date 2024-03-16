<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class WebBlogResource extends JsonResource
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
            'post_title' => $this->post_title,
            'post_excerpt' => $this->post_excerpt,
            'post_status' => $this->post_status,
            'ID' => $this->ID,
            'post_date' => $this->post_date,
            'post_type' => $this->post_type,
            'image' => isset($this->meta_attachment->meta_attachment->meta_value) ?  'https://theciu.vn/blog/wp-content/uploads' . $this->meta_attachment->meta_attachment->meta_value : null,
            'slug' => $this->meta_attachment->meta_attachment->meta_value
        ];
    }
}
