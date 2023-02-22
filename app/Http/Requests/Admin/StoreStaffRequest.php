<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('web')->user()->can('create user');
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
            'phone' => 'phone_number|required|unique:users,phone',
            'email' => 'required|unique:users,email'
        ];
    }

    public function attributes(){
        return [
            'fullname' => trans('labels.fullname'),
        ];
    }
}
