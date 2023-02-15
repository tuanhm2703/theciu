<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ProfileInfoComponent extends Component {
    public $user;
    public $showPasswordForm;
    public $old_password;
    public $new_password;
    public $new_password_confirmation;
    public function mount() {
        $this->user = auth('customer')->user();
        $this->showPasswordForm = false;
    }

    protected $profileRules = [
        'user.email' => 'required|email',
        'user.first_name' => 'required',
        'user.last_name' => 'required'
    ];

    public function render() {
        return view('livewire.profile-info-component');
    }

    public function update() {
        $this->validate($this->profileRules);
        $this->user->save();
        session()->flash('message', 'Cập nhật thông tin thành công.');
    }

    public function showPasswordForm() {
        $this->showPasswordForm = true;
    }

    public function returnToProfile() {
        $this->showPasswordForm = false;
    }

    public function updatePassword() {
        $passwordRules = [
            'old_password' => 'password_match:' . $this->user->password . '|required',
            'new_password' => 'password_new:' . $this->user->password . '|required',
            'new_password_confirmation' => 'required|same:new_password'
        ];
        $messages = [
            'new_password_confirmation.same' => 'Mật khẩu xác nhận không khớp'
        ];
        $this->validate($passwordRules, $messages, [
            'new_password' => trans('labels.new_password'),
            'old_password' => trans('labels.old_password'),
            'new_password_confirmation' => trans('labels.new_password_confirmation')
        ]);
        $this->user->password = Hash::make($this->new_password);
        $this->user->save();
        session()->flash('message', 'Cập nhật mật khẩu thành công.');
        $this->new_password = '';
        $this->old_password = '';
        $this->new_password_confirmation = '';
    }
}
