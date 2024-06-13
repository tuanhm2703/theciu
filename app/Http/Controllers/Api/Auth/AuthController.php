<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\MediaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateProfileAvatarRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Resources\Api\CustomerResource;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use App\Responses\Api\BaseResponse;
use App\Services\StorageService;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public function logout(Request $request) {
        requestUser()->currentAccessToken()->delete();
        return BaseResponse::success([
            'message' => 'Logout successfully!'
        ]);
    }

    public function profile() {
        $customer = requestUser();
        return BaseResponse::success(new CustomerResource($customer));
    }

    public function updateProfile(UpdateProfileRequest $request) {
        $data = $request->validated();
        $user = requestUser();
        $user->update($data);
        return BaseResponse::success(new CustomerResource($user));
    }

    public function updateAvatar(UpdateProfileAvatarRequest $request) {
        $user = requestUser();
        if ($user->avatar) {
            StorageService::delete($user->avatar?->path);
            $user->avatar?->delete();
        }
        $user->createImages([$request->avatar], MediaType::AVATAR);
        return BaseResponse::success([
            'message' => 'Cập nhật avatar thành công',
            'url' => $user->avatar()->first()?->path_with_domain
        ]);
    }

    public function deleteAvatar() {
        $user = requestUser();
        if ($user->avatar) {
            StorageService::delete($user->avatar?->path);
            $user->avatar?->delete();
        }
        return BaseResponse::success([
            'message' => 'Xoá avatar thành công'
        ]);
    }

    public function deleteProfile() {
        $user = requestUser();
        $user->delete();
        return BaseResponse::success([
            'message' => 'Xoá tài khoản thành công'
        ]);
    }
}
