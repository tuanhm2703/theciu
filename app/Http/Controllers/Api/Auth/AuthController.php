<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
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
}
