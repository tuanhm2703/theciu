<?php

namespace App\Http\Services\Checkout;

use App\Models\Order;

class CheckoutResult {
    public $order;
    public $redirectUrl;

    public function __construct(Order $order, $redirectUrl) {
        $this->order = $order;
        $this->redirectUrl = $redirectUrl;
    }
}
