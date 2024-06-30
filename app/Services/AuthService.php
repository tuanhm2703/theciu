<?php

namespace App\Services;

use App\Enums\CustomerAuthType;
use App\Enums\OtpType;
use App\Exceptions\Api\ApiException;
use App\Exceptions\Api\OtpException;
use App\Http\Resources\Api\CustomerResource;
use App\Http\Services\OtpService;
use App\Models\Customer;
use App\Responses\Api\BaseResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService {
    public function __construct(private OtpService $otpService) {
    }
    public function login(string $username, string $password) {
        $customer = Customer::findByUserName($username);
        if ($customer && Hash::check($password, $customer->password) && $customer->auth_type === CustomerAuthType::CLIENT) {
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

    public function sendLoginOtp(string $username) {
        DB::beginTransaction();
        try {
            $customer = Customer::findByUserName($username);
            if (isPhone($username)) {
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
        } catch (\Throwable $th) {
            throw new ApiException("Gửi mã otp không thành công");
        }
    }

    public function loginWithOtp(string $username, string $otp) {
        DB::beginTransaction();
        try {
            $customer = Customer::findByUserName($username);
            $this->otpService->verifyOtp($customer, $otp, OtpType::LOGIN);
            $accessToken = $customer->createToken('personal-access-token')->plainTextToken;
            DB::commit();
            return BaseResponse::success([
                'access_token' => $accessToken,
                'user' => new CustomerResource($customer)
            ]);
        } catch (OtpException $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw new ApiException("Gửi mã otp không thành công");
        }
    }

    private function sendVerifyOtp(Customer $customer, string $type) {
        $otp = $this->otpService->createOtp($customer, $type);
        $this->otpService->sendOtp($customer->phone, $otp->code);
        return $otp;
    }

    public function generateDeviceAuthentication(string $deviceToken = null) {
        $customer = Customer::where('device_token', $deviceToken)->whereNotNull('device_token')->first();
        if (!$customer) {
            $deviceToken = $this->generateUniqueDeviceToken();
            $customer = new Customer();
            $customer->password = bcrypt($deviceToken);
            $customer->auth_type = CustomerAuthType::DEVICE;
            $customer->device_token = $deviceToken;
            $customer->save();
        }
        $accessToken = $customer->createToken('personal-access-token')->plainTextToken;
        return BaseResponse::success([
            'access_token' => $accessToken,
            'user' => new CustomerResource($customer)
        ]);
    }

    private function generateUniqueDeviceToken(): string {
        return str()->uuid()->toString();
    }
}
