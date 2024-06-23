<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class BaseRequest extends FormRequest {
    protected $failAuthorizationMessage = 'Bạn không có quyền truy cập đến yêu cầu này.';
    protected function failedAuthorization() {
        throw new HttpResponseException(response()->json([
            'error' => $this->failAuthorizationMessage
        ], 403));
    }

    // Optionally, override the validation failure response
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
