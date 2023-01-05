<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\client\LoginRequest;
use App\Models\Customer;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller {
    public function login(LoginRequest $request) {
        $credentials = $request->only([
            'username',
            'password'
        ]);
        if(isEmail($credentials['username'])) {
            if (auth('customer')->attempt(['email' => $credentials['username'], 'password' => $credentials['password']])) {
                return redirect()->back();
            }
        } else {
            if (auth('customer')->attempt(['phone' => $credentials['username'], 'password' => $credentials['password']])) {
                return redirect()->back();
            }
        }
        throw new UnauthorizedException('Tài khoản hoặc mật khẩu không đúng');
    }
}
