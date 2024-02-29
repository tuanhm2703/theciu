<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'saveable' => (boolean) $this->saveable,
            'voucher_type' => $this->voucher_type->name,
            'quantity_left' => $this->quantity,
            'min_order_value' => $this->min_order_value,
            'discount_type' => $this->discount_type,
            'max_discount_amount' => $this->max_discount_amount,
            'display' => $this->display,
            'begin' => $this->begin,
            'end' => $this->end,
            'num_of_days_left' => $this->end->diffInDays($this->begin),
            'saved' => false
        ];
    }
}
