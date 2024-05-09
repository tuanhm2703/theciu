<?php

namespace App\Http\Services;

use App\Exceptions\Api\OtpException;
use App\Jobs\SendEmailJob;
use App\Mail\CustomerLoginOtpEmail;
use App\Mail\CustomerResetPassworOtpEmail;
use App\Models\Customer;
use App\Models\Otp;

class OtpService {
    public function createOtp(Customer $customer, string $type) {
        $last_otp = $customer->otps()->where('type', $type)->latest()->first();
        if($last_otp && !$last_otp->isExpired()) {
            $second_left = $last_otp->expired_at->diffInSeconds(now());
            throw new OtpException("Vui lòng thử lại sau $second_left giây");
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

    public function sendOtp($phone, $otp, $message) {

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
