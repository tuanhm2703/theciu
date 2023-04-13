<?php

namespace App\Traits\Common;


trait LazyloadLivewire {
    public $readyToLoad = false;

    public function loadContent() {
        $this->readyToLoad = true;
    }
}
