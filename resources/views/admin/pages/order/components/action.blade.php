<div class="d-flex flex-column">
    {!! Form::model($order, [
        'url' => route('admin.order.status.update', $order->id),
        'method' => 'PUT',
        'class' => 'change-status-form',
    ]) !!}
    @switch($order->order_status)
        @case(App\Enums\OrderStatus::WAIT_TO_ACCEPT)
            <input type="hidden" name="order_status" value="{{ App\Enums\OrderStatus::WAITING_TO_PICK }}">
            <input type="hidden" name="sub_status" value="{{ App\Enums\OrderSubStatus::PREPARING }}">
            <button type="submit" class="raw-a-button link-button"><i class="opacity-6 fas fa-truck"></i>
                {{ trans('labels.preparing') }}</button>
        @break

        @case(App\Enums\OrderStatus::WAITING_TO_PICK)
            @switch($order->sub_status)
                @case(App\Enums\OrderSubStatus::PREPARING)
                <a class="ajax-modal-btn" href="javascript:;" data-modal-size="modal-xl"
                        data-link="{{ route('admin.order.pickup_address.list', ['order' => $order->id]) }}">
                        {{ trans('labels.finish_packaging') }}</a>
                @break

                @case(App\Enums\OrderSubStatus::FINISH_PACKAGING)
                    <a class="d-block link-button ajax-modal-btn m-0" href="javascript:;"
                        data-link="{{ route('admin.order.shipping_order', ['order' => $order->id]) }}">{{ trans('labels.shipping_info') }}</a>
                        <a class="link-button" target="_blank" href="{{ route('admin.order.shipping_order.print', $order->id) }}">
                            In phiếu giao
                        </a>
                @break

                @default
            @endswitch
        @break

        @default
    @endswitch
    {!! Form::close() !!}
    <a href="{{ route('admin.order.details', $order->id) }}" class="link-button">
        <i class="fab fa-sistrix"></i>
        Xem chi tiết</a>
</div>
<script>
    $('.change-status-form').ajaxForm({
        success: (res) => {
            orderTable.ajax.reload()
            toast.success("{{ trans('toast.action_successful') }}", res.data.message)
        },
        error: (err) => {
            tata.error("{{ trans('toast.action_failed') }}", err.responseJSON.message)
        }
    })
</script>
