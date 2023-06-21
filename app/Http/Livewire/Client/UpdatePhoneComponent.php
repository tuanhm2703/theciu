<?php

namespace App\Http\Livewire\Client;

use App\Models\Customer;
use App\Services\Models\FirebaseErrorCode;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UpdatePhoneComponent extends Component
{
    public $apiKey;
    public $sessionInfo;
    public $recaptchaToken;
    public $phone;
    public $otp;
    public $errorMessage;
    public $verified;

    protected function rules()
    {
        return [
            'phone' => "required|phone_number|unique:customers,phone,".customer()->id,
        ];
    }

    protected function messages() {
        return [
            'phone.unique' => 'Số điện thoại đã được sử dụng'
        ];
    }

    public function render()
    {
        return view('livewire.client.update-phone-component');
    }
    public function returnToProfile()
    {
        return route('client.auth.profile.index');
    }
    public function sendVerify()
    {
        $this->validate();
        $this->sendVerifyRequest();
    }
    public function sendVerifyRequest()
    {
        $client = new Client();
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:sendVerificationCode?key=$this->apiKey";
        try {
            $response = $client->post($url, [
                'body' => json_encode([
                    'phoneNumber' => "+84" . $this->phone,
                    // 'recaptchaToken' => $this->recaptchaToken
                ])
            ]);
            if ($response->getStatusCode() == 200) {
                $this->verified = true;
            }
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
    public function updatePhone()
    {
        $this->validate();
        $url = "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPhoneNumber?key=$this->apiKey";
        $client = new Client();
        try {
            $client->post($url, [
                'body' => json_encode(
                    [
                        'code' => $this->otp,
                        'sessionInfo' => $this->sessionInfo
                    ],
                )
            ]);
            $customer = customer();
            $customer->phone = $this->phone;
            $customer->phone_verified = true;
            $customer->save();
            $this->dispatchBrowserEvent('openToast', [
                'type' => 'success',
                'message' => 'Cập nhật số điện thoại thành công'
            ]);
            return redirect()->route('client.auth.profile.index');
        } catch (\GuzzleHttp\Exception\ClientException $th) {
            $code = json_decode($th->getResponse()->getBody()->getContents())->error->message;
            $this->errorMessage = FirebaseErrorCode::getErrorMessageFromCode($code);
        }
    }
}
