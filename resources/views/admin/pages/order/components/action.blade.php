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
            {!! Form::submit(trans('labels.preparing'), ['class' => 'raw-a-button']) !!}
        @break

        @case(App\Enums\OrderStatus::WAITING_TO_PICK)
            @switch($order->sub_status)
                @case(App\Enums\OrderSubStatus::PREPARING)
                    <a class="ajax-modal-btn" href="javascript:;" data-modal-size="sm"
                        data-link="{{ route('admin.order.pickup_address.list', ['order' => $order->id]) }}">{{ trans('labels.finish_packaging') }}</a>
                @break

                @default
            @endswitch
        @break

        @default
    @endswitch
    {!! Form::close() !!}
    <a href="{{ route('admin.order.details', $order->id) }}">Xem thêm</a>
</div>
<script>
    $('.change-status-form').ajaxForm({
        success: (res) => {
            orderTable.ajax.reload()
            tata.success("{{ trans('toast.action_successful') }}", res.data.message)
        },
        error: (err) => {
            tata.error("{{ trans('toast.action_failed') }}", err.responseJSON.message)
        }
    })
</script>
