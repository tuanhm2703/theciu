<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
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
            'inventories' => OrderInventoryListResource::collection($this->inventories),
            'payment_method' => $this->payment_method->name,
            'created_at' => $this->created_at->format('d/m/Y'),
            'order_status_label' => $this->getCurrentStatusLabel(),
            'order_status' => $this->order_status,
            'total' => $this->total,
            'order_number' => $this->order_number,
            'freeship_voucher_amount' => $this->freeship_voucher?->pivot->amount,
            'order_voucher_amount' => $this->order_voucher?->pivot->amount,
            'combo_discount' => $this->combo_discount,
            'additional_discount' => $this->additional_discount,
            'note' => $this->note,
            'bonus_note' => $this->bonus_note,
            'payment_status' => $this->payment_status,
            'order_histories' => OrderHistoryResource::collection($this->order_histories)
        ];
    }
}
