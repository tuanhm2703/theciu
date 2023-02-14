<?php

namespace App\Http\Controllers\Client;

use App\Enums\SocialProviderType;
use App\Enums\MediaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\client\LoginRequest;
use App\Http\Requests\client\RegisterRequest;
use App\Models\Customer;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller {
    public function login(LoginRequest $request) {
        $credentials = $request->only([
            'username',
            'password'
        ]);
        if (isEmail($credentials['username'])) {
            $customer = Customer::whereEmail($credentials['username'])->whereNull('provider')->first();
        } else {
            $customer = Customer::wherePhone($credentials['username'])->whereNull('provider')->first();
        }
        if (Hash::check($credentials['password'], $customer->password)) {
            auth('customer')->login($customer);
            return redirect()->back();
        } else {
            return BaseResponse::error([
                'errors' => [
                    'password' => ['Mật khẩu không đúng']
                ]
            ], 422);
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
    public function redirectToProvider() {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback() {
        $user = (object) Socialite::driver('facebook')->user()->attributes;
        $customer_names = collect(explode(' ', $user->name));
        $customer = Customer::firstOrCreate([
            'socialite_account_id' => $user->id
        ], [
            'first_name' => $customer_names->first(),
            'last_name' => $customer_names->count() > 1 ? $customer_names->last() : null,
            'email' => $user->email,
            'provider' => SocialProviderType::FACEBOOK,
            'password' => Hash::make($user->id)
        ]);

        if (!$customer->avatar) {
            $customer->createImagesFromUrls([$user->avatar], MediaType::AVATAR);
        }
        auth('customer')->login($customer);
        return  redirect()->back();
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request) {
        $user = Socialite::driver('google')->user()->user;
        $user = (object) $user;

        $customer = Customer::updateOrCreate([
            'socialite_account_id' => $user->id
        ], [
            'first_name' => $user->given_name,
            'last_name' => $user->family_name,
            'email' => $user->email,
            'provider' => SocialProviderType::GOOGLE,
            'password' => Hash::make($user->id)
        ]);

        if (!$customer->avatar) {
            $customer->createImagesFromUrls([$user->picture], MediaType::AVATAR);
        }
        auth('customer')->login($customer);
        return redirect()->to('/');
    }
}
