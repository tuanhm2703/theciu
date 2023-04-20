<?php

namespace App\Http\Livewire\Client;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ResetPasswordComponent extends Component
{
    public $new_password;
    public $new_password_confirmation;
    public $token;
    public $username;
    public $customer;
    protected $queryString = [
        'token',
        'username'
    ];
    public function mount() {
        $this->customer = Customer::findByUsername($this->username);
        if($this->customer) {
            $this->customer->email = $this->customer->email ? $this->customer->email : $this->customer->phone;
        }
        if(!app('auth.password.broker')->tokenExists($this->customer, $this->token)) {
            abort(404);
        }
    }
    public function render()
    {
        return view('livewire.client.reset-password-component');
    }

    public function updatePassword() {
        $this->customer->password = Hash::make($this->new_password);
        $this->customer->save();
        auth('customer')->login($this->customer);
        return redirect('/');
    }
}
