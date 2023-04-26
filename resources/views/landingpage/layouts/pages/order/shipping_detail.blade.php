<div class="card p-5">
    <div class="card-header">
        <h5 class="text-center">Lịch sử đơn hàng</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between py-3 my-3 border-bottom">
            <div><h6 class="mb-0">Mã vận đơn</h6></div>
            <div>
                <h6>{{ $order->shipping_order->code }}</h6>
            </div>
        </div>
        <div class="row">
            <div class="box">
                <div class="box__body">
                    <div class="timeline">
                        @foreach ($order->order_histories as $index => $order_history)
                            <div class="timeline__row">
                                <div class="timeline__row_icon">
                                    <div class="timeline-icon {{ $index == 0 ? 'text-success border-success' : '' }}">
                                        <i class="{{ $order_history->action->icon }}"></i>
                                    </div>
                                </div>
                                <div class="timeline__row_content">
                                    <div class="timeline__row_content_desc">
                                        <h6 class="mb-0 {{ $index == 0 ? 'text-success' : '' }}">
                                            {{ $order_history->action->description }}
                                        </h6>
                                        <div class="log-info-wrapper">
                                            <span class="log-description">{{ $order_history->description }}</span>
                                            <br>
                                            <small
                                                class="log-time">{{ $order_history->created_at->format('H:i d/m/Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
