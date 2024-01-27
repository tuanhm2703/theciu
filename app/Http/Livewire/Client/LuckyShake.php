<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

class LuckyShake extends Component {
    public $btnClicked = false;
    public $discounts = [
        10000,
        10000,
        10000,
        10000,
        10000,
        20000,
        20000,
        20000,
        30000,
        30000
    ];
    public $discount_image = '';
    public $discount_amount = 0;
    public function render() {
        return view('livewire.client.lucky-shake');
    }
    public function preventShake() {
        session()->put('lucky-shake-show', true);
    }
    public function shake() {
        $this->preventShake();
        $this->btnClicked = true;
        $this->discount_amount = $this->discounts[random_int(0, 9)];
        switch ($this->discount_amount) {
            case 10000:
                $this->discount_image = asset('img/stick1.png');
                break;
            case 20000:
                $this->discount_image = asset('img/stick2.png');
                break;
            case 30000:
                $this->discount_image = asset('img/stick3.png');
                break;
            default:
                # code...
                break;
        }
    }
    public function confirmOrder() {
        session()->put('lucky_discount_amount', $this->discount_amount);
        $this->emit('checkOrder', $this->discount_amount);
    }
}
