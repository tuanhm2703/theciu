<div>
    <ul class="nav nav-tabs" id="order-type-tab" role="tablist" wire:ignore>
        <li class="nav-item">
            <a class="nav-link active" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::ALL }})" aria-controls="order-list"
                aria-selected="true">Tất cả ({{ $order_counts->sum('order_count') }})</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::WAIT_TO_ACCEPT }})" aria-controls="order-list"
                aria-selected="true">Chờ xác nhận
                ({{ $order_counts->where('order_status', App\Enums\OrderStatus::WAIT_TO_ACCEPT)->first() ? $order_counts->where('order_status', App\Enums\OrderStatus::WAIT_TO_ACCEPT)->first()->order_count : 0 }})</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::WAITING_TO_PICK }})" aria-controls="order-list"
                aria-selected="true">Chờ lấy hàng
                ({{ $order_counts->where('order_status', App\Enums\OrderStatus::WAITING_TO_PICK)->first() ? $order_counts->where('order_status', App\Enums\OrderStatus::WAITING_TO_PICK)->first()->order_count : 0 }})</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::PICKING }})" aria-controls="order-list"
                aria-selected="true">Đang lấy hàng
                ({{ $order_counts->where('order_status', App\Enums\OrderStatus::PICKING)->first() ? $order_counts->where('order_status', App\Enums\OrderStatus::PICKING)->first()->order_count : 0 }})</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::PICKING }})" aria-controls="order-list"
                aria-controls="order-list" aria-selected="true">Đang lấy hàng
                ({{ $order_counts->where('order_status', App\Enums\OrderStatus::PICKING)->first() ? $order_counts->where('order_status', App\Enums\OrderStatus::PICKING)->first()->order_count : 0 }})</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::DELIVERING }})" aria-controls="order-list"
                aria-selected="true">Đang giao
                ({{ $order_counts->where('order_status', App\Enums\OrderStatus::DELIVERING)->first() ? $order_counts->where('order_status', App\Enums\OrderStatus::DELIVERING)->first()->order_count : 0 }})</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::DELIVERED }})" aria-controls="order-list"
                aria-selected="true">Đã giao
                ({{ $order_counts->where('order_status', App\Enums\OrderStatus::DELIVERED)->first() ? $order_counts->where('order_status', App\Enums\OrderStatus::DELIVERED)->first()->order_count : 0 }})</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::CANCELED }})" aria-controls="order-list"
                aria-selected="true">Đơn huỷ
                ({{ $order_counts->where('order_status', App\Enums\OrderStatus::CANCELED)->first() ? $order_counts->where('order_status', App\Enums\OrderStatus::CANCELED)->first()->order_count : 0 }})</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active mt-3" id="order-list" role="tabpanel" aria-labelledby="order-list-tab">
            @foreach ($orders as $order)
                <livewire:client.order-card-component :key="time() . $order->id" :order="$order">
                </livewire:client.order-card-component>
            @endforeach
            <div>
                <div class="text-center">
                    @if ($orders->count() > 0)
                        <button class="btn" wire:click.prevent="nextPage()">
                            <div class="text-center" wire:loading>
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <span wire:loading.remove>Xem thêm</span>
                        </button>
                    @else
                        Không có đơn hàng nào
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="voucher-popup container newsletter-popup-container d-none" id="review-voucher-gift">
</div>

