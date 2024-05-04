<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CustomerResource;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return BaseResponse::success([
            'message' => 'Logout successfully!'
        ]);
    }

    public function profile() {
        $customer = request()->user();
        return BaseResponse::success(new CustomerResource($customer));
    }
}
