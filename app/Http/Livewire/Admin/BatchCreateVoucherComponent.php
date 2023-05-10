<?php

namespace App\Http\Livewire\Admin;

use App\Models\Voucher;
use Livewire\Component;

class BatchCreateVoucherComponent extends Component {
    public $codes = [];
    public $codeQuantity;
    public $codePrefix;
    protected $rules = [
        'codeQuantity' => 'required|numeric|min:1',
        'codePrefix' => 'required|min:2|max:4'
    ];
    public function render() {
        return view('livewire.admin.batch-create-voucher-component');
    }
    public function addCode($quantity, $prefix) {
        $this->codeQuantity = $quantity;
        $this->codePrefix = $prefix;
        $this->validate(null, [], [
            'codeQuantity' => 'số lượng',
            'codePrefix' => 'đầu mã voucher'
        ]);
        $numberOfCharacter = -10 + strlen($prefix);
        for ($i=0; $i < $quantity; $i++) {
            $this->codes[$i] = $prefix.strtoupper(substr(md5(uniqid(rand(), true)), $numberOfCharacter));
            while(Voucher::whereCode($this->codes[$i])->exists()) {
                $this->codes[$i] = $prefix.strtoupper(substr(md5(uniqid(rand(), true)), $numberOfCharacter));
            }
        }
        $this->emit('closeModal');
    }

    public function updateCodeFromArray($index, $value) {
        $this->codes[$index] = $value;
    }
    public function removeCodeFromArray($index) {
        unset($this->codes[$index]);
    }
}
