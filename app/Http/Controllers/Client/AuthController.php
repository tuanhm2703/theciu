<?php

namespace App\Http\Controllers\Client;

use App\Enums\SocialProviderType;
use App\Enums\MediaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\LoginRequest;
use App\Http\Requests\Client\RegisterRequest;
use App\Models\Customer;
use App\Responses\Admin\BaseResponse;
use Meta;
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
        auth('customer')->login($customer);
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
        $user = (object) Socialite::driver('facebook')->stateless()->user()->attributes;
        $customer_names = collect(explode(' ', $user->name));
        if($user->email) {
            $customer = Customer::firstOrCreate([
                'email' => $user->email
            ], [
                'first_name' => $customer_names->first(),
                'last_name' => $customer_names->count() > 1 ? $customer_names->last() : null,
                'provider' => SocialProviderType::FACEBOOK,
                'socialite_account_id' => $user->id
            ]);
        } else {
            $customer = Customer::firstOrCreate([
                'socialite_account_id' => $user->id
            ], [
                'first_name' => $customer_names->first(),
                'last_name' => $customer_names->count() > 1 ? $customer_names->last() : null,
                'provider' => SocialProviderType::FACEBOOK,
            ]);
        }
        $customer->update([
            'socialite_account_id' => $user->id
        ]);

        if (!$customer->avatar) {
            try {
                $customer->createImagesFromUrls([$user->avatar], MediaType::AVATAR);
            } catch (\Throwable $th) {
                \Log::error($th);
            }
        }
        auth('customer')->login($customer);
        syncSessionCart();
        return redirect()->intended();
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request) {
        $user = Socialite::driver('google')->stateless()->user()->user;
        $user = (object) $user;

        if($user->email) {
            $customer = Customer::firstOrCreate([
                'email' => $user->email,
            ], [
                'first_name' => $user->given_name,
                'last_name' => isset($user->family_name) ? $user->family_name : '',
                'provider' => SocialProviderType::GOOGLE,
                'socialite_account_id' => $user->id
            ]);
        } else {
            $customer = Customer::firstOrCreate([
                'socialite_account_id' => $user->id,
            ], [
                'first_name' => $user->given_name,
                'last_name' => $user->family_name,
                'provider' => SocialProviderType::GOOGLE
            ]);
        }

        $customer->update([
            'socialite_account_id' => $user->id
        ]);

        if (!$customer->avatar) {
            $customer->createImagesFromUrls([$user->picture], MediaType::AVATAR);
        }
        auth('customer')->login($customer);
        syncSessionCart();
        return redirect()->intended();
    }

    public function forgotPassword() {
        Meta::set('title', 'The C.I.U - Quên mật khẩu');
        Meta::set('description', 'Trang quên mật khẩu giúp người dùng khôi phục lại mật khẩu của họ khi đã bị quên. Tại đây, bạn có thể nhập địa chỉ email đã đăng ký và chúng tôi sẽ gửi liên kết để bạn thiết lập mật khẩu mới.');
        return view('landingpage.layouts.pages.auth.forgot_password');
    }

    public function resetPassword() {
        return view('landingpage.layouts.pages.auth.reset_password');
    }

}
