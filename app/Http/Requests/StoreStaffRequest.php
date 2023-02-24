<?php

namespace App\Http\Requests;

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
        return user()->can('create user');
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
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function attributes(){
        return [
            'fullname' => trans('labels.fullname'),
            'password_confirmation' => 'mật khẩu xác nhận'
        ];
    }
}
