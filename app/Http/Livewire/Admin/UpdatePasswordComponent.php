<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class UpdatePasswordComponent extends Component
{
    public $old_password;
    public $new_password;
    public $new_password_confirmation;

    protected $rules;

    public function mount() {

    }

    public function render()
    {
        return view('livewire.admin.update-password-component');
    }

    public function updatePassword() {
        $messages = [
            'new_password_confirmation.same' => 'Mật khẩu xác nhận không khớp'
        ];
        $rules = [
            'old_password' => 'password_match:' . user()->password . '|required',
            'new_password' => 'password_new:' . user()->password . '|required',
            'new_password_confirmation' => 'required|same:new_password'
        ];
        $this->validate($rules, $messages, [
            'new_password' => trans('labels.new_password'),
            'old_password' => trans('labels.old_password'),
            'new_password_confirmation' => trans('labels.new_password_confirmation')
        ]);
        user()->password = $this->new_password;
        user()->save();
        session()->flash('success', trans('Cập nhật mật khẩu thành công'));
        $this->old_password = null;
        $this->new_password = null;
        $this->new_password_confirmation = null;
    }
}
