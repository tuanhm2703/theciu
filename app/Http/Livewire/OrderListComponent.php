<?php

namespace App\Http\Livewire;

use App\Enums\OrderStatus;
use Livewire\Component;
use Livewire\WithPagination;

class OrderListComponent extends Component {
    public $orders;

    public $page;

    public $pageSize = 2;

    public $status = 0;

    public function mount() {
        $this->page = 1;
        $this->orders = auth('customer')->user()->orders()->with(['inventories' => function ($q) {
            $q->with('image:path,imageable_id', 'product:id,name,slug', 'attributes:id,name');
        }])->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize);
        if($this->status != 0) {
            $this->orders->where('order_status', $this->status);
        }
        $this->orders = $this->orders->get();
    }

    public function render() {
        return view('livewire.order-list-component');
    }

    public function nextPage() {
        $this->page++;
        $orders = auth('customer')->user()->orders()->with(['inventories' => function ($q) {
            $q->with('image:path,imageable_id', 'product:id,name,slug', 'attributes:id,name');
        }])->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize);
        if($this->status != 0) {
            $orders->where('order_status', $this->status);
        }
        $orders = $orders->get();
        $this->orders = $this->orders->merge($orders);
    }
}
