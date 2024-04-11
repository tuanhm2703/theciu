<?php

namespace App\Http\Controllers\Api;

use App\Enums\MediaType;
use App\Enums\SocialProviderType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\CustomerResource;
use App\Models\Customer;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller {
    public function login(LoginRequest $request) {
        if (isPhone($request->username)) {
            $credentials = ['phone' => $request->username, 'password' => $request->password];
        } else {
            $credentials = ['email' => $request->username, 'password' => $request->password];
        }
        if (auth('api')->attempt($credentials, $request->remember)) {
            $user = auth('api')->user();
            $accessToken = $user->createToken('personal-access-token')->plainTextToken;
            return BaseResponse::success([
                'access_token' => $accessToken,
                'user' => new CustomerResource($user)
            ]);
        } else {
            return BaseResponse::error([
                'message' => 'Unauthenticated'
            ], 401);
        }
    }

    public function redirectToProvider() {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback() {
        $user = (object) Socialite::driver('facebook')->stateless()->user()->attributes;
        $customer_names = collect(explode(' ', $user->name));
        if ($user->email) {
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
                Log::error($th);
            }
        }
        auth('api')->login($customer);
        $accessToken = $user->createToken('personal-access-token')->plainTextToken;
        return BaseResponse::success([
            'access_token' => $accessToken,
            'user' => new CustomerResource($user)
        ]);
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request) {
        $user = Socialite::driver('google')->stateless()->user()->user;
        $user = (object) $user;

        if ($user->email) {
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
        auth('api')->login($user);
        $accessToken = $user->createToken('personal-access-token')->plainTextToken;
        return BaseResponse::success([
            'access_token' => $accessToken,
            'user' => new CustomerResource($user)
        ]);
    }

    public function register(RegisterRequest $request) {
        DB::beginTransaction();
        $data = $request->validated();
        try {
            $input = [
                'password' => Hash::make($data['password']),
                'email' => $data['email'],
                'phone' => $data['phone'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone_verified' => 0
            ];
            $customer = Customer::create($input);
            DB::commit();
            auth('api')->login($customer);
            $accessToken = auth('api')->user()->createToken('personal-access-token')->plainTextToken;
            return BaseResponse::success([
                'access_token' => $accessToken,
                'user' => new CustomerResource(auth('api')->user())
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
        }
    }
}
