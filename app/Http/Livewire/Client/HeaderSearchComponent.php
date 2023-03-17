<?php

namespace App\Http\Livewire\Client;

use App\Enums\KeywordCount;
use Livewire\Component;

class HeaderSearchComponent extends Component
{
    use KeywordCount;

    public function render()
    {
        return view('livewire.client.header-search-component');
    }
}
