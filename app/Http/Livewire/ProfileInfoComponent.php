<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ProfileInfoComponent extends Component {
    public $user;
    public $old_password;
    public $new_password;
    public $new_password_confirmation;
    public function mount() {
        $this->user = auth('customer')->user();
    }

    protected $profileRules = [
        'user.email' => 'required|email',
        'user.first_name' => 'required',
        'user.last_name' => 'required',
        'user.phone' => 'required|phone_number'
    ];

    protected $rules = [
        'user.email' => 'required|email',
        'user.first_name' => 'required',
        'user.last_name' => 'required',
        'user.phone' => 'required|phone_number'
    ];

    public function render() {
        return view('livewire.profile-info-component');
    }

    public function update() {
        $this->validate($this->profileRules);
        $this->user->save();
        session()->flash('message', 'Cập nhật thông tin thành công.');
    }

}
