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
use App\Services\Models\FirebaseErrorCode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
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

    public function sendVerifyOtp(Request $request) {
        $phone = $request->username;
        $recaptchaToken = $request->recaptcha_token;
        $apiKey = $request->api_key;
        $client = new Client();
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:sendVerificationCode?key=$apiKey";
        try {
            $response = $client->post($url, [
                'body' => json_encode([
                    'phoneNumber' => "+84" . $phone,
                    'recaptchaToken' => $recaptchaToken
                ])
            ]);
            return BaseResponse::success([
                'message' => 'Mã xác nhận đã được gửi đến số điện thoại',
                'session_info' => json_decode($response->getBody()->getContents())->sessionInfo
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $th) {
            Log::error($th->getMessage());
            $code = json_decode($th->getResponse()->getBody()->getContents())->error->message;
            $message = FirebaseErrorCode::getErrorMessageFromCode($code);
            return BaseResponse::error([
                'message' => $message
            ], 400);
        }
    }

    public function forgotPassword(Request $request) {
        if (isPhone($request->username)) {
            return $this->sendVerifyOtp($request);
        } else {
            $customer = Customer::findByUserName($request->username);
            if ($customer) {
                $token = app('auth.password.broker')->createToken($customer);
                $customer->sendPasswordResetNotification($token);
                return BaseResponse::success([
                    'message' => 'Mã xác nhận đã được gửi đến email'
                ]);
            } else {
                return BaseResponse::error([
                    'message' => 'Email không tồn tại'
                ], 400);
            }
        }
    }

    public function resetPassword(Request $request) {
        $customer = Customer::findByUsername($request->username);
        if (!$customer) return BaseResponse::error([
            'message' => 'Tài khoản không tồn tại'
        ]);
        if (isPhone($request->username)) {
            try {
                $this->verifyOtp($request);
            } catch (ClientException $th) {
                Log::error($th->getMessage());
                $code = json_decode($th->getResponse()->getBody()->getContents())->error->message;
                switch ($code) {
                    case 'SESSION_EXPIRED':
                        $message = 'Mã xác nhận đã hết hạn';
                        break;
                    default:
                        $message = 'Đã có lỗi xảy ra, vui lòng thử lại sau.';
                        break;
                }
                return BaseResponse::error([
                    'message' => $message
                ], 400);
            }
        } else {
            if (!app('auth.password.broker')->tokenExists($customer, $request->token)) {
                return BaseResponse::error([
                    'message' => 'Token không hợp lệ'
                ]);
            }
        }
        $customer->password = Hash::make($request->new_password);
        $customer->save();
        $accessToken = auth('api')->user()->createToken('personal-access-token')->plainTextToken;
        return BaseResponse::success([
            'access_token' => $accessToken,
            'user' => new CustomerResource(auth('api')->user())
        ]);
    }

    private function verifyOtp(Request $request) {
        $key = $request->api_key;
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPhoneNumber?key=$key";
        $client = new Client();
        $client->post($url, [
            'body' => json_encode(
                [
                    'code' => $request->otp,
                    'sessionInfo' => $request->session_info
                ],
            )
        ]);
    }
}
