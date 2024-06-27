<?php

namespace App\Http\Controllers\Api;

use App\Enums\MediaType;
use App\Enums\OtpType;
use App\Enums\SocialProviderType;
use App\Exceptions\Api\OtpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\LoginWithOtpRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\SendLoginOtpRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
use App\Http\Resources\Api\CustomerResource;
use App\Http\Services\OtpService;
use App\Models\Customer;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller {
    public function __construct(private OtpService $otpService) {
    }
    public function login(LoginRequest $request) {
        $customer = Customer::findByUserName($request->username);
        if ($customer && Hash::check($request->password, $customer->password)) {
            $accessToken = $customer->createToken('personal-access-token')->plainTextToken;
            return BaseResponse::success([
                'access_token' => $accessToken,
                'user' => new CustomerResource($customer)
            ]);
        } else {
            return BaseResponse::error([
                'message' => 'Unauthenticated'
            ], 401);
        }
    }

    public function sendLoginOtp(SendLoginOtpRequest $request) {
        DB::beginTransaction();
        try {
            $customer = Customer::findByUserName($request->username);
            if (isPhone($request->username)) {
                $otp = $this->sendVerifyOtp($customer, OtpType::LOGIN);
            } else {
                $otp = $this->otpService->createOtp($customer, OtpType::LOGIN);
                $this->otpService->sendLoginOtpEmail($customer, $otp->code);
            }
            DB::commit();
            return BaseResponse::success([
                'message' => 'Mã otp đã được gửi thành công',
                'otp' => $otp->code
            ]);
        } catch (OtpException $th) {
            throw $th;
        }
    }

    public function loginWithOtp(LoginWithOtpRequest $request) {
        DB::beginTransaction();
        try {
            $customer = Customer::findByUserName($request->username);
            $this->otpService->verifyOtp($customer, $request->otp, OtpType::LOGIN);
            $accessToken = $customer->createToken('personal-access-token')->plainTextToken;
            DB::commit();
            return BaseResponse::success([
                'access_token' => $accessToken,
                'user' => new CustomerResource($customer)
            ]);
        } catch (OtpException $th) {
            throw $th;
        }
    }

    public function redirectToProvider() {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback(Request $request) {
        $user = (object) Socialite::driver('facebook')->userFromToken($request->access_token)->attributes;
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
        $accessToken = $customer->createToken('personal-access-token')->plainTextToken;
        return BaseResponse::success([
            'access_token' => $accessToken,
            'user' => new CustomerResource($customer)
        ]);
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request) {
        $user = (object) Socialite::driver('google')->userFromToken($request->access_token)->attributes;
        if ($user->email) {
            $customer = Customer::firstOrCreate([
                'email' => $user->email,
            ], [
                'first_name' => getFirstAndMiddleName($user->name),
                'last_name' => getLastName($user->name),
                'provider' => SocialProviderType::GOOGLE,
                'socialite_account_id' => $user->id
            ]);
        } else {
            $customer = Customer::firstOrCreate([
                'socialite_account_id' => $user->id,
            ], [
                'first_name' => getFirstAndMiddleName($user->name),
                'last_name' => getLastName($user->name),
                'provider' => SocialProviderType::GOOGLE
            ]);
        }

        $customer->update([
            'socialite_account_id' => $user->id
        ]);

        if (!$customer->avatar) {
            $customer->createImagesFromUrls([$user->picture], MediaType::AVATAR);
        }
        auth('api')->login($customer);
        $accessToken = $customer->createToken('personal-access-token')->plainTextToken;
        return BaseResponse::success([
            'access_token' => $accessToken,
            'user' => new CustomerResource($customer)
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

    private function sendVerifyOtp(Customer $customer, string $type) {
        $otp = $this->otpService->createOtp($customer, $type);
        $this->otpService->sendOtp($customer->phone, $otp->code);
        return $otp;
    }

    public function forgotPassword(ForgotPasswordRequest $request) {
        DB::beginTransaction();
        try {
            $customer = Customer::findByUsername($request->username);
            if (isPhone($request->username)) {
                $otp = $this->sendVerifyOtp($customer, OtpType::RESET_PASSWORD);
                DB::commit();
                return BaseResponse::success([
                    'message' => 'Mã xác nhận đã được gửi đến số điện thoại',
                    'otp' => $otp->code
                ]);
            } else {
                $otp = $this->otpService->createOtp($customer, OtpType::RESET_PASSWORD);
                $this->otpService->sendOtpEmailForResetPassword($customer, $otp->code);
                return BaseResponse::success([
                    'message' => 'Mã xác nhận đã được gửi đến email'
                ]);
            }
        } catch (OtpException $th) {
            throw $th;
        }
    }

    public function verifyOtp(VerifyOtpRequest $request) {
        DB::beginTransaction();
        try {
            $customer = Customer::findByUserName($request->username);
            $this->otpService->verifyOtp($customer, $request->otp, $request->type);
            $response = null;
            switch ($request->type) {
                case OtpType::RESET_PASSWORD:
                    $repsonse = $this->responseForResetPassword($customer);
                case OtpType::LOGIN:
                    $repsonse = $this->responseForLogin($customer);
            }
            DB::commit();
            return $response;
        } catch (OtpException $th) {
            throw $th;
        }
    }

    private function responseForResetPassword(Customer $customer) {
        $token = $token = app('auth.password.broker')->createToken($customer);
        return BaseResponse::success([
            'token' => $token,
            'message' => 'Xác nhận otp thành công'
        ]);
    }

    private function responseForLogin(Customer $customer) {
        $accessToken = $customer->createToken('personal-access-token')->plainTextToken;
        return BaseResponse::success([
            'access_token' => $accessToken,
            'user' => new CustomerResource($customer)
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request) {
        DB::beginTransaction();
        try {
            $customer = Customer::findByUsername($request->username);
            $password_broker = app('auth.password.broker');
            if (!$password_broker->tokenExists($customer, $request->token)) {
                return BaseResponse::error([
                    'message' => 'Token không hợp lệ'
                ], 400);
            }
            $customer->password = Hash::make($request->new_password);
            $customer->save();
            $accessToken = $customer->createToken('personal-access-token')->plainTextToken;
            $password_broker->deleteToken($customer);
            DB::commit();
            return BaseResponse::success([
                'access_token' => $accessToken,
                'user' => new CustomerResource($customer)
            ]);
        } catch (OtpException $th) {
            throw $th;
        }
    }
}
