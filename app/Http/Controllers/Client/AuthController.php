<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\client\LoginRequest;
use App\Http\Requests\client\RegisterRequest;
use App\Models\Customer;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller {
    public function login(LoginRequest $request) {
        $credentials = $request->only([
            'username',
            'password'
        ]);
        if (isEmail($credentials['username'])) {
            if (auth('customer')->attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
                return redirect()->back();
            }
        } else {
            if (auth('customer')->attempt(['phone' => $credentials['username'], 'password' => $credentials['password']])) {
                return redirect()->back();
            }
        }
        return BaseResponse::error([
            'message' => 'Tài khoản hoặc mật khẩu không đúng'
        ], 401);
    }

    public function register(RegisterRequest $request) {
        $request->merge([
            'password' => Hash::make($request->input('password')),
            'email' => isEmail($request->input('username')) ? $request->input('username') : null,
            'phone' => isPhone($request->input('username')) ? $request->input('username') : null,
        ]);
        $customer = Customer::create($request->all());
        auth('customer')->login($customer);
        return BaseResponse::success([
            'message' => 'Đăng ký thành công'
        ]);
    }
}
