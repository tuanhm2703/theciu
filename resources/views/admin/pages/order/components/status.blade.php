<h6>{{ $order->getCurrentStatusLabel() }}
    @if ($order->order_status == App\Enums\OrderStatus::CANCELED)
        <i class="far fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
            title="{{ $order->cancel_reason }}"></i>
        <br>
    @endif
</h6>
@if ($order->order_status == App\Enums\OrderStatus::CANCELED)
<p>Bị huỷ bởi {{ $order->getCancelerLabel() }}</p>
@endif
