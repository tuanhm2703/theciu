<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class ProfileContentComponent extends Component {
    public $content;
    public $order;

    protected $listeners = ['setContent' => 'setContent'];

    public function render() {
        return view('livewire.profile-content-component');
    }

    public function setContent($content, $orderId = null) {
        $this->content = $content;
        if ($orderId) {
            $this->order = Order::find($orderId);
        }
        $this->dispatchBrowserEvent('profile-content:contentChanged', $content);
    }
}
