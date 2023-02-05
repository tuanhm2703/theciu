<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

class OrderDetails extends Component {
    public $order;

    public function render() {
        return view('livewire.client.order-details');
    }
}
