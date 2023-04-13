<?php

namespace App\Http\Livewire\Client;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterComponent extends Component
{
    public $username;

    public $password;

    public $password_confirmation;

    public $first_name;

    public $last_name;

    protected $rules = [
        'username' => 'required|username_have_not_been_used|valid_username',
        'password' => 'required|confirmed',
        'first_name' => 'required',
        'last_name' => 'required',
    ];
    public function render()
    {
        return view('livewire.client.register-component');
    }

    public function register() {
        $this->validate();
        $input = [
            'password' => Hash::make($this->password),
            'email' => isEmail($this->username) ? $this->username : null,
            'phone' => isPhone($this->username) ? $this->username : null,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name
        ];
        $customer = Customer::create($input);
        auth('customer')->login($customer);
        return redirect()->intended();
    }
}
