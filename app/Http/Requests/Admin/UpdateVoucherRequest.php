<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return user()->can('update voucher');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'discount_type' => 'string|required',
            'code' => 'string|unique:vouchers,code,'.$this->route('voucher')->code,
            'status' => 'required',
            'value' => 'numeric',
            'min_order_value' => 'numeric'
        ];
    }
}
