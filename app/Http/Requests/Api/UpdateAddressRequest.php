<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->user('sanctum')->addresses()->where('id', $this->address->id)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fullname' => 'required',
            'details' => 'required',
            'phone' => 'required|phone_number',
            'province_id' => 'required',
            'ward_id' => 'required',
            'featured' => 'nullable'
        ];
    }
}
