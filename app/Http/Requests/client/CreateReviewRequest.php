<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'product_score' => 'required',
            'customer_service_score' => 'required',
            'shipping_service_score' => 'required',
            'color' => 'required',
            'reality' => 'required',
            'material' => 'required',
            'details' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'color' => 'màu sắc',
            'reality' => 'đúng với mô tả',
            'material' => 'chất liệu',
            'details' => 'đánh giá chi tiết'
        ];
    }
}
