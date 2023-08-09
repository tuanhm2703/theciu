<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

class SpinnerWheel extends Component
{
    public $deg;

    public $gift_arr = [];
    public $gift;
    public $showGift = false;

    public $order;
    public function mount() {
        $step_deg = 36;
        $deg = 360 - ($step_deg / 2);
        for ($i=0; $i < 10; $i++) {
            $key = '';
            $image = '';
            $name = '';
            if($i == 0) {
                $key = 'bottle';
                $image = asset('img/water-bottle.png');
                $name = 'Bình nước di động THE C.I.U';
            } else if($i % 4 == 0) {
                $key = 'bag';
                $image = asset('img/bag.png');
                $name = 'Túi ba gang THE C.I.U';
            } else if($i % 2 == 0){
                $key = 'mirror';
                $image = asset('img/mirror.png');
                $name = 'Gương thần THE C.I.U';
            } else {
                $key  = 'notebook';
                $image = asset('img/note-book.png');
                $name = 'Sổ tay THE C.I.U';
            }
            $max = $deg + $step_deg >= 360 ? $deg + $step_deg - 360 : $deg + $step_deg;
            $this->gift_arr[] = [
                'min' => $deg,
                'max' => $max,
                'value' => $key,
                'img' => $image,
                'name' => $name
            ];
            $deg = $max;
        }
    }
    public function render()
    {
        return view('livewire.client.spinner-wheel');
    }

    public function getDeg() {
        $ran = rand(0, 360);
        if($ran > $this->gift_arr[0]['min']) {
            $gift = $this->gift_arr[0];
        } else {
            $gift = collect($this->gift_arr)->where('min', '<=', $ran)->where('max', '>=', $ran)->first();
        }
        $this->gift = $gift;
        $this->deg = $ran + 3600;
    }

    public function updateGift() {
        $this->showGift = true;
        $this->order->bonus_note = $this->gift['name'];
        $this->order->save();
    }
}
