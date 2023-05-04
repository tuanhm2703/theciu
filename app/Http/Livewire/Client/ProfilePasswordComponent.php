<?php

namespace App\Http\Livewire\Client;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ProfilePasswordComponent extends Component
{
    public $user;

    public $old_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount() {
        $this->user = customer();
    }
    protected function rules()
    {
        if (!empty(customer()->password)) {
            return [
                'old_password' => 'password_match:' . $this->user->password . '|required',
                'new_password' => 'password_new:' . $this->user->password . '|required',
                'new_password_confirmation' => 'required|same:new_password'
            ];
        }
        return [
            'new_password' => 'min:6|required',
            'new_password_confirmation' => 'required|same:new_password'
        ];
    }
    protected function messages()
    {
        return [
            'new_password_confirmation.same' => 'Mật khẩu xác nhận không khớp'
        ];
    }

    public function render()
    {
        return view('livewire.client.profile-password-component');
    }

    public function updatePassword()
    {
        $this->validate(null, [], [
            'new_password' => trans('labels.new_password'),
            'old_password' => trans('labels.old_password'),
            'new_password_confirmation' => trans('labels.new_password_confirmation')
        ]);
        $this->user->password = Hash::make($this->new_password);
        $this->user->save();
        $this->new_password = '';
        $this->old_password = '';
        $this->new_password_confirmation = '';
        $this->dispatchBrowserEvent('openToast', [
            'message' => 'Cập nhật mật khẩu thành công'
        ]);
    }

    public function returnToProfile()
    {
        return route('client.auth.profile.index');
    }
}
