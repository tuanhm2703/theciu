<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'string',
            'last_name' => 'string',
            'email' => 'email|unique:customers,email,'.request()->user()->id,
            'phone' => 'phone_number|unique:customers,phone,'.request()->user()->id
        ];
    }
}
