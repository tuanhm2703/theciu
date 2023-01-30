<div style="line-height: 1.4em">
    <span class="text-dark">{{ $order->shipping_order->getShipServiceName() }}</span>
    <br>
    <small>{{ $order->shipping_order->shipping_service->name }}</small><br>
    @if (!empty($order->shipping_order->code))
        <small class="">{{ $order->shipping_order->code }}</small>
    @endif

</div>
