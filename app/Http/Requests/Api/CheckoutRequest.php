<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'order_voucher_id' => 'nullable|integer|exists:vouchers,id',
            'freeship_voucher_id' => 'nullable|integer|exists:vouchers,id',
            'address_id' => 'nullable|integer|required|exists:addresses,id',
            'accom_gift_promotion' => 'nullable',
            'accom_gift_promotion.id' => 'integer|required|exists:promotions,id',
            'accom_gift_promotion.inventory_ids.*' => 'integer|required',
            'accom_product_promotion' => 'nullable',
            'accom_product_promotion.id' => 'integer|required|exists:promotions,id',
            'accom_product_promotion.inventory_ids.*' => 'integer|required'
        ];
    }
}
