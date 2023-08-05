<?php

namespace App\Http\Livewire\Client;

use App\Models\Customer;
use GuzzleHttp\Client;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ForgotPasswordComponent extends Component
{
    public $username;
    public $verified = false;
    public $otp;
    public $errorMessage;
    public $mailSent = false;
    public $apiKey;
    public $sessionInfo;
    public $recaptchaToken;

    protected $rules = [
        'username' => 'required|valid_username|username_exists',
    ];
    public function render()
    {
        return view('livewire.client.forgot-password-component');
    }

    public function sendForgetPhoneRequest()
    {
        $client = new Client();
        $key = $this->apiKey;
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:sendVerificationCode?key=$key";
        try {
            $response = $client->post($url, [
                'body' => json_encode([
                    'phoneNumber' => "+84" . $this->username,
                    'recaptchaToken' => $this->recaptchaToken
                ])
            ]);
            if ($response->getStatusCode() == 200) {
                $this->verified = true;
            }
            $this->sessionInfo = json_decode($response->getBody()->getContents())->sessionInfo;
        } catch (\GuzzleHttp\Exception\ClientException $th) {
            \Log::error($th->getMessage());
            $code = json_decode($th->getResponse()->getBody()->getContents())->error->message;
            switch ($code) {
                case 'SESSION_EXPIRED':
                    $this->errorMessage = 'Mã xác nhận đã hết hạn';
                    break;
                default:
                    $this->errorMessage = 'Đã có lỗi xảy ra, vui lòng thử lại sau.';
                    break;
            }
        }
    }

    public function sendVerify($username, $apiKey, $recaptchaToken)
    {
        $this->validate();
        if (isPhone($username)) {
            $this->username = $username;
            $this->apiKey = $apiKey;
            $this->recaptchaToken = $recaptchaToken;
            $this->sendForgetPhoneRequest();
        } else {
            $customer = Customer::findByUserName($this->username);
            $token = app('auth.password.broker')->createToken($customer);
            $customer->sendPasswordResetNotification($token);
            $this->mailSent = true;
        };
    }
    public function verifyOtp($code)
    {
        $key = $this->apiKey;
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPhoneNumber?key=$key";
        $client = new Client();
        try {
            $client->post($url, [
                'body' => json_encode(
                    [
                        'code' => $code,
                        'sessionInfo' => $this->sessionInfo
                    ],
                )
            ]);
            $user = Customer::findByUserName($this->username);
            $user->email = $user->email ? $user->email : $user->phone;
            $token = app('auth.password.broker')->createToken($user);
            return redirect()->route('client.auth.resetPassword', ['token' => $token, 'username' => $this->username]);
        } catch (\GuzzleHttp\Exception\ClientException $th) {
            $code = json_decode($th->getResponse()->getBody()->getContents())->error->message;
            switch ($code) {
                case 'SESSION_EXPIRED':
                    $this->errorMessage = 'Mã xác nhận đã hết hạn';
                    break;
                default:
                    $this->errorMessage = 'Mã xác nhận không đúng';
                    break;
            }
        }
    }
}
