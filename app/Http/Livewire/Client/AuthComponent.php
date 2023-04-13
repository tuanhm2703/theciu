<?php

namespace App\Http\Livewire\Client;

use App\Traits\Common\LazyloadLivewire;
use Livewire\Component;

class AuthComponent extends Component
{
    use LazyloadLivewire;
    public function render()
    {
        return view('livewire.client.auth-component');
    }
}
