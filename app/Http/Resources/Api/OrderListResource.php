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
            'id' => $this->id,
            'inventories' => OrderInventoryListResource::collection($this->inventories),
            'order_histories' => OrderHistoryResource::collection($this->order_histories),
            'order_status_label' => $this->getCurrentStatusLabel(),
            'created_at' => $this->created_at->format('d/m/Y'),
            'payment_method' => $this->payment_method->name,
            'order_status' => $this->order_status,
            'order_number' => $this->order_number,
            'note' => $this->note,
            'bonus_note' => $this->bonus_note,
            'payment_status' => $this->payment_status,
            'cancel_reason' => $this->cancel_reason,
            'total' => $this->total,
            'subtotal' => $this->subtotal,
            'additional_discount' => $this->additional_discount,
            'combo_discount' => $this->combo_discount,
            'rank_discount' => $this->rank_discount_value,
            'shipping_fee' => (int) $this->shipping_order?->total_fee,
            'freeship_voucher_amount' => (int) $this->freeship_voucher?->pivot->amount,
            'order_voucher_amount' => (int) $this->order_voucher?->pivot->amount,
        ];
    }
}
