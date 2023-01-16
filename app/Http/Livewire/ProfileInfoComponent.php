<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProfileInfoComponent extends Component {
    public $user;

    public function mount() {
        $this->user = auth('customer')->user();
    }
    public function render() {
        return view('livewire.profile-info-component');
    }

    public function update() {
        $this->user->save();
        session()->flash('message', 'Cập nhật thông tin thành công.');
    }

    protected $rules = [
        'user.email' => 'required|email',
        'user.first_name' => 'required',
        'user.last_name' => 'required'
    ];
}
