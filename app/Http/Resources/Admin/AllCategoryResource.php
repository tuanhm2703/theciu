<?php

namespace App\Http\Resources\Admin;

use App\Enums\CategoryType;
use Illuminate\Http\Resources\Json\JsonResource;

class AllCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $addProductBtn = '<button class="btn btn-link text-dark px-3 mb-0 ajax-modal-btn" href="javascript:;"
        data-link="'.route('admin.ajax.category.view.add_product', ['category' => $this->id]).'"><i class="fas fa-cube"></i></button>';
        return [
            "id" => $this->id,
            "text" => $this->type === CategoryType::COLLECTION ? $this->name . $addProductBtn : $this->name,
            "checked" => false,
            "hasChildren" => $this->categories->count() > 0,
            "children" => AllCategoryResource::collection($this->categories)
        ];
    }
}
