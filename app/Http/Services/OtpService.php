<?php

namespace App\Http\Services;

use App\Exceptions\Api\OtpException;
use App\Http\Services\SMSService\Exceptions\ZNSException;
use App\Http\Services\SMSService\VietGuysService;
use App\Http\Services\SMSService\ZaloZNSService;
use App\Jobs\SendEmailJob;
use App\Mail\CustomerLoginOtpEmail;
use App\Mail\CustomerResetPassworOtpEmail;
use App\Models\Customer;
use App\Models\Otp;
use Carbon\CarbonInterval;
use Exception;

class OtpService {
public function __construct(private ZaloZNSService $znsService, private VietGuysService $smsService) {

    }
    public function createOtp(Customer $customer, string $type) {
        $last_otp = $customer->otps()->where('type', $type)->latest()->first();
        if($last_otp && !$last_otp->isExpired()) {
            $second_left = $last_otp->expired_at->diffInSeconds(now());
            $readable_time = CarbonInterval::seconds($second_left)->cascade()->forHumans();
            throw new OtpException("Vui lòng thử lại sau $readable_time");
        }
        do {
            $otp = $this->generateOtp();
        } while (Otp::where('code', $otp)->where('type', $type)->exists());
        return $customer->otps()->create([
            'type' => $type,
            'code' => $otp,
            'expired_at' => now()->addSeconds(config('otp.expired_time')),
        ]);
    }

    private function generateOtp($length = 6) {
        // Generate a random 6-digit OTP
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= mt_rand(0, 9);
        }
        return $otp;
    }

    public function sendOtp(string $phone, string $otp) {
        try {
            $this->znsService->sendOtp(addCountryCodeToPhoneNumber($phone), $otp);
        } catch (Exception $th) {
            $time = CarbonInterval::seconds(config('otp.expired_time'))->cascade()->forHumans();
            $this->smsService->sendOtp(addCountryCodeToPhoneNumber($phone), $otp, $time);
        }
    }

    public function verifyOtp(Customer $customer, $otp, $type) {
        $otp = $customer->otps()->where('code', $otp)->where('type', $type)->first();
        if(!$otp) {
            throw new OtpException("Mã otp không đúng");
        }
        if($otp->isExpired()) {
            throw new OtpException("Otp đã hết hạn, vui lòng thử lại");
        }
        $otp->delete();
    }

    public function sendOtpEmailForResetPassword(Customer $customer, string $otp) {
        dispatch(new SendEmailJob($customer->email, new CustomerResetPassworOtpEmail($otp)));
    }

    public function sendLoginOtpEmail(Customer $customer, string $otp) {
        dispatch(new SendEmailJob($customer->email, new CustomerLoginOtpEmail($otp)));
    }
}
