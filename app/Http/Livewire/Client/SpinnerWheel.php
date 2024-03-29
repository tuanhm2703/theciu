<?php

namespace App\Http\Livewire\Client;

use Livewire\Component;

class SpinnerWheel extends Component {
    public $deg;

    public $gift_arr = [];
    public $gift = [
        'key' => ''
    ];
    public $showGift = false;

    public $order;
    public $active;
    public $background;
    public $hideHeader = false;
    public function mount() {
        $this->background = asset('img/spinner-bg.png');
        $this->active = now()->between('2023-12-22 00:00:00', '2023-12-31 23:59:59') || (env('APP_ENV') != 'prod');
        // $this->active = false;
        // dd($this->active);
        $step_deg = 36;
        $deg = 360 - ($step_deg / 2);
        for ($i = 0; $i < 10; $i++) {
            $key = '';
            $image = '';
            $name = '';
            if (in_array($i, [0, 6])) {
                $key = 'calendar';
                $image = "";
                $name = '';
            } else if (in_array($i, [3, 8])) {
                $key = 'candle';
                $image = "";
                $name = "";
            } else if (in_array($i, [1, 4, 7])) {
                $key = 'crunchies-1';
                $image = asset('img/crunchies-1.png');
                $name = 'Crunchies 1';
            } else {
                $key  = 'crunchies-2';
                $image = asset('img/crunchies-2.png');
                $name = 'Crunchies 2';
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
        \Log::info(json_encode($this->gift_arr));
    }
    public function render() {
        return view('livewire.client.spinner-wheel');
    }

    public function getDeg() {
        $key = null;
        while (!in_array($key, ['crunchies-1', 'crunchies-2'])) {
            $ran = rand(0, 360);
            if ($ran % 18 == 0) {
                $ran -= 10;
            }
            if ($ran > $this->gift_arr[0]['min']) {
                $gift = $this->gift_arr[0];
            } else {
                $gift = collect($this->gift_arr)->where('min', '<', $ran)->where('max', '>', $ran)->first();
            }
            if($gift) {
                $this->gift = $gift;
                $key = $this->gift['value'];
                $this->deg = $ran + 3600;
            }
        }
        \Log::info("Deg: $ran");
    }

    public function updateGift() {
        $this->showGift = true;
        $this->order->bonus_note = $this->gift['name'];
        $this->order->save();
        $this->background = '';
        $this->hideHeader = true;
    }
}
