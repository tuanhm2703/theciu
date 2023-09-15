<?php

namespace App\Http\Livewire\Client;

use App\Models\Customer;
use Livewire\Component;

class LoginComponent extends Component
{
    public $username;

    public $password;
    public $remember = false;
    public $currentRoute;
    protected $rules = [
        'username' => 'required|username_exists',
        'password' => 'required|correct_password',
    ];

    public function render()
    {
        return view('livewire.client.login-component');
    }

    public function login() {
        $this->validate([
            'username' => 'required|username_exists',
            'password' => 'required|correct_password:customers,'.$this->username,
        ]);
        $customer = Customer::findByUserName($this->username);
        $intendedUrl = session()->get('url.intended');
        auth('customer')->login($customer, $this->remember);
        if($intendedUrl) {
            return redirect()->intended();
        }
        $this->dispatchBrowserEvent('refreshPage');
    }
}
