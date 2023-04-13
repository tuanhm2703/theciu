<?php

namespace App\Http\Livewire\Client;

use App\Traits\Common\LazyloadLivewire;
use Livewire\Component;

class AuthStatusComponent extends Component
{
    use LazyloadLivewire;
    public function render()
    {
        return view('livewire.client.auth-status-component');
    }
}
