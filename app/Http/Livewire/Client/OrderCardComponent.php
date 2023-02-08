<?php

namespace App\Http\Livewire\Client;

use App\Http\Services\Payment\PaymentService;
use Livewire\Component;

class OrderCardComponent extends Component {
    public $order;

    public function render() {
        return view('livewire.client.order-card-component');
    }

    public function pay() {
        $url = PaymentService::checkout($this->order);
        return redirect()->to($url);
    }
}
