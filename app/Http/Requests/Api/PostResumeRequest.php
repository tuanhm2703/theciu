<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostResumeRequest extends BaseRequest
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
            'fullname' => 'required',
            'phone' => 'required',
            'email' => 'email|required',
            'self_introduce' => 'required',
            'strength' => 'required',
            'question' => 'required',
            'expected_salary' => 'required'
        ];
    }
}
