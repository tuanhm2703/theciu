<div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                aria-controls="order-list" aria-selected="true">Tất cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                aria-controls="order-list" aria-selected="true">Xác nhận</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                aria-controls="order-list" aria-selected="true">Chờ lấy hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                aria-controls="order-list" aria-selected="true">Đang giao</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                aria-controls="order-list" aria-selected="true">Đã giao</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                aria-controls="order-list" aria-selected="true">Đơn huỷ</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab"
                aria-controls="order-list" aria-selected="true">Trả hàng/Hoàn tiền</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active mt-3" style="width: 80%" id="order-list" role="tabpanel"
            aria-labelledby="order-list-tab">
            @foreach ($orders as $order)
                @foreach ($order->inventories as $inventory)
                    <div class="d-flex py-3 justify-content-between">
                        <div class="d-flex">
                            <a href="{{ route('client.product.details', $inventory->product->slug) }}"
                                style="background: url({{ $inventory->image->path_with_domain }}); width: 70px; height: 70px; background-size: cover; background-position:center"></a>
                            <div class="ml-3" style="line-height: 1rem">
                                <h6>{{ $inventory->product->name }}</h6>
                                <p>Phân loại hàng: {{ $inventory->title }}</p>
                                <span class="font-weight-bold text-md">x{{ $inventory->pivot->quantity }}</span>
                            </div>
                        </div>
                        <div class="product-price">
                            @if ($inventory->pivot->promotion_price < $inventory->pivot->origin_price)
                                <span class="old-price">₫{{ format_currency($inventory->pivot->origin_price) }}</span>
                                <span
                                    class="new-price ml-1">₫{{ format_currency($inventory->pivot->promotion_price) }}</span>
                            @else
                                ₫{{ format_currency($inventory->pivot->origin_price) }}
                            @endif
                        </div>
                    </div>
                @endforeach
                <hr class="my-0">
                <div class="text-right">
                    <p>
                        Thành tiền: <span class="font-weight-bold text-danger">₫{{ format_currency($order->total) }}</span>
                    </p>
                </div>
            @endforeach
            <div>
                <div wire:loading class="text-center">Loading...</div>
                <div class="text-center">
                    <button class="btn" wire:click.prevent="nextPage()">Xem thêm</button>
                </div>
            </div>
        </div>
    </div>
</div>
