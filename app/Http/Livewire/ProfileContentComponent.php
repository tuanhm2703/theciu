<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProfileContentComponent extends Component {
    public $content;

    public function render() {
        return view('livewire.profile-content-component');
    }

    public function setContent($content) {
        $this->content = $content;
    }
}
