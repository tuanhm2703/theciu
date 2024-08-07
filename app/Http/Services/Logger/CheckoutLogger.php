<?php

namespace App\Http\Services\Logger;

class CheckoutLogger extends Logger {
    public function __construct() {
        $this->channel = 'checkout';
    }
}
