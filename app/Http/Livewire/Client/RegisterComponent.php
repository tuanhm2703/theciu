<?php

namespace App\Http\Livewire\Client;

use App\Models\Customer;
use App\Services\Models\FirebaseErrorCode;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RegisterComponent extends Component {
    public $username;

    public $password;

    public $password_confirmation;

    public $first_name;

    public $last_name;
    public $otp;
    public $phone;
    public $email;

    public $apiKey;
    public $errorMessage;

    public $recaptchaToken;

    public $sessionInfo;

    public $requestPhone;

    protected $rules = [
        'phone' => 'required|unique:customers,phone|phone_number',
        'email' => 'required|unique:customers,email',
        'password' => 'required|confirmed',
        'first_name' => 'required',
        'last_name' => 'required',
    ];
    public function render() {
        return view('livewire.client.register-component');
    }

    public function register() {
        $this->validate();
        DB::beginTransaction();
        try {
            $input = [
                'password' => Hash::make($this->password),
                'email' => $this->email,
                'phone' => $this->phone,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone_verified' => 1
            ];
            $customer = Customer::create($input);
            if($this->verifyOtp()) {
                DB::commit();
                auth('customer')->login($customer);
                $intendedUrl = session()->get('url.intended');
                if($intendedUrl) {
                    return redirect()->intended();
                }
                $this->dispatchBrowserEvent('refreshPage');
            }
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
        }
    }

    private function verifyOtp() {
        $key = $this->apiKey;
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPhoneNumber?key=$key";
        $client = new Client();
        try {
            if($this->requestPhone !== $this->phone) {
                $this->errorMessage = 'Mã xác nhận không đúng';
                return false;
            }
            $client->post($url, [
                'body' => json_encode(
                    [
                        'code' => $this->otp,
                        'sessionInfo' => $this->sessionInfo
                    ],
                )
            ]);
            return true;
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
        return false;
    }
    public function sendVerify() {
        $this->validate();
        $this->sendVerifyRequest();
    }
    public function sendVerifyRequest() {
        $client = new Client();
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:sendVerificationCode?key=$this->apiKey";
        try {
            $response = $client->post($url, [
                'body' => json_encode([
                    'phoneNumber' => "+84" . $this->phone,
                    'recaptchaToken' => $this->recaptchaToken
                ])
            ]);
            $this->requestPhone = $this->phone;
            $this->sessionInfo = json_decode($response->getBody()->getContents())->sessionInfo;
            $this->dispatchBrowserEvent('openToast', [
                'type' => 'success',
                'message' => 'Mã xác nhận đã được gửi đến số điện thoại'
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $th) {
            Log::error($th->getMessage());
            $code = json_decode($th->getResponse()->getBody()->getContents())->error->message;
            $this->errorMessage = FirebaseErrorCode::getErrorMessageFromCode($code);
        }
    }
}
