<?php

namespace App\Http\Livewire;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class OrderListComponent extends Component {
    public $orders;

    public $page;

    public $pageSize = 2;

    public $status = OrderStatus::ALL;

    public $order_counts;

    public function mount() {
        $this->order_counts = customer()->orders()->selectRaw('count(id) as order_count, order_status')->groupBy('order_status')->get();
        $this->page = 1;
        $this->orders = auth('customer')->user()->orders()->with(['inventories' => function ($q) {
            $q->with('image:path,imageable_id', 'product:id,name,slug', 'attributes:id,name');
        }])->withCount('review')->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize);
        if($this->status != 0) {
            $this->orders->where('order_status', $this->status);
        }
        $this->orders = $this->orders->get();
    }
    private function getOrders() {

    }

    public function render() {
        return view('livewire.order-list-component');
    }

    public function nextPage() {
        $this->page++;
        $orders = auth('customer')->user()->orders()->with(['inventories' => function ($q) {
            $q->with('image:path,imageable_id', 'product:id,name,slug', 'attributes:id,name');
        }])->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize);
        if($this->status != OrderStatus::ALL) {
            $orders->where('order_status', $this->status);
        }
        $orders = $orders->get();
        $this->orders = $this->orders->merge($orders);
    }

    public function changeOrderStatus($status) {
        $this->order_counts = customer()->orders()->selectRaw('count(id) as order_count, order_status')->groupBy('order_status')->get();
        $this->status = $status;
        $this->page = 1;
        $this->orders = auth('customer')->user()->orders()->with(['inventories' => function ($q) {
            $q->with('image:path,imageable_id', 'product:id,name,slug', 'attributes:id,name');
        }])->withCount('review')->latest()->skip(($this->page - 1) * $this->pageSize)->take($this->pageSize);
        if($this->status != OrderStatus::ALL) {
            $this->orders->where('order_status', $this->status);
        }
        $this->orders = $this->orders->get();
    }
}
