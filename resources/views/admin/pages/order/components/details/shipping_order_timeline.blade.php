<div class="row">
    <div class="box">
        <div class="box__body">
            <div class="shipping-history-timeline timeline timeline-closed">
                @foreach ($order->shipping_order->shipping_order_histories as $index => $shipping_history)
                    <div class="timeline__row">
                        <div class="timeline__row_icon">
                            <div class="timeline-icon {{ $index == 0 ? 'text-success border-success' : '' }}">
                                <i style="font-size: 14px" class="fas fa-circle"></i>
                            </div>
                        </div>
                        <div class="timeline__row_content">
                            <div class="timeline__row_content_desc">
                                <h6 class="mb-0 {{ $index == 0 ? 'text-success' : '' }}">
                                    {{ $shipping_history->reason }}
                                </h6>
                                <div class="log-info-wrapper">
                                    <small
                                        class="log-time">{{ $shipping_history->created_at->format('H:i d/m/Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <span id="expan-timeline-btn" class="text-success closed">
                    Mở rộng <i class="fas fa-chevron-down"></i>
                </span>
            </div>
        </div>
    </div>
</div>
