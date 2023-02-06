<div>
    <ul class="nav nav-tabs" id="myTab" role="tablist" wire:ignore>
        <li class="nav-item">
            <a class="nav-link active" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::ALL }})" aria-controls="order-list"
                aria-selected="true">Tất cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::WAIT_TO_ACCEPT }})" aria-controls="order-list"
                aria-selected="true">Chờ xác nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::WAITING_TO_PICK }})" aria-controls="order-list"
                aria-selected="true">Chờ lấy hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::PICKING }})" aria-controls="order-list"
                aria-controls="order-list" aria-selected="true">Đang lấy hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::DELIVERING }})" aria-controls="order-list"
                aria-selected="true">Đang giao</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::DELIVERED }})" aria-controls="order-list"
                aria-selected="true">Đã giao</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                wire:click="changeOrderStatus({{ App\Enums\OrderStatus::CANCELED }})" aria-controls="order-list"
                aria-selected="true">Đơn huỷ</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active mt-3" id="order-list" role="tabpanel"
            aria-labelledby="order-list-tab">
            @foreach ($orders as $order)
                @component('components.client.order-card', compact('order'))
                @endcomponent
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
                            <span wire:loading.remove>Xem thêm</span></button>
                    @else
                        Không có đơn hàng nào
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
