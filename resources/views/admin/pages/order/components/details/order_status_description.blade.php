@switch($order->order_status)
    @case(App\Enums\OrderStatus::WAIT_TO_ACCEPT)
        <p>Người mua đang đợi bạn giao hàng</p>
        <div style="height: 100px; background: #f4f4f4" class="d-flex justify-content-between align-items-center px-3 rounded">
            <div class="text-uppercase">
                TIẾP THEO BẠN CÓ THỂ
            </div>
            <div class="d-flex justify-content-between">
                <button class="btn btn-default me-3 m-0 bg-white ajax-modal-btn" data-modal-size="sm"
                    data-link="{{ route('admin.order.view.cancel', $order->id) }}">
                    Huỷ đơn hàng
                </button>
                {!! Form::model($order, [
                    'url' => route('admin.order.status.update', $order->id),
                    'method' => 'PUT',
                    'class' => 'update-order-status-form',
                ]) !!}
                {!! Form::hidden('order_status', App\Enums\OrderStatus::WAITING_TO_PICK, []) !!}
                {!! Form::hidden('sub_status', App\Enums\OrderSubStatus::PREPARING, []) !!}
                {!! Form::submit('Chuẩn bị hàng', ['class' => 'btn btn-primary m-0']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    @break

    @case(App\Enums\OrderStatus::WAITING_TO_PICK)
        @switch($order->sub_status)
            @case(App\Enums\OrderSubStatus::PREPARING)
                <div style="height: 100px; background: #f4f4f4" class="d-flex justify-content-between align-items-center px-3 rounded">
                    <div class="text-uppercase">
                        TIẾP THEO BẠN CÓ THỂ
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-default m-0 me-3 bg-white ajax-modal-btn" data-modal-size="sm"
                            data-link="{{ route('admin.order.view.cancel', $order->id) }}">
                            Huỷ đơn hàng
                        </button>
                        <a class="btn btn-primary ajax-modal-btn m-0" href="javascript:;"
                            data-link="{{ route('admin.order.pickup_address.list', ['order' => $order->id]) }}">{{ trans('labels.finish_packaging') }}</a>
                    </div>
                </div>
            @break

            @case(App\Enums\OrderSubStatus::FINISH_PACKAGING)
                <div style="height: 100px; background: #f4f4f4" class="d-flex justify-content-between align-items-center px-3 rounded">
                    <div class="text-uppercase">
                        TIẾP THEO BẠN CÓ THỂ
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-default m-0 me-3 bg-white ajax-modal-btn" data-modal-size="sm"
                            data-link="{{ route('admin.order.view.cancel', $order->id) }}">
                            Huỷ đơn hàng
                        </button>
                        <a class="btn btn-primary ajax-modal-btn m-0" href="javascript:;"
                            data-link="{{ route('admin.order.shipping_order', ['order' => $order->id]) }}">{{ trans('labels.shipping_info') }}</a>
                    </div>
                </div>
            @break

            @default
        @endswitch
    @break

    @case(App\Enums\OrderStatus::CANCELED)
        <div style="height: 50px; background: #f4f4f4" class="d-flex align-items-center px-3 rounded">
            <b>{{ trans('labels.cancel_reason') }}: </b> <i class="ps-3">{{ $order->cancel_reason }}</i>
        </div>
    @break
    @case(App\Enums\OrderStatus::PICKING)
        <div style="height: 50px; background: #f4f4f4" class="d-flex align-items-center px-3 rounded">
            <b>{{ trans('labels.cancel_reason') }}: </b> <i class="ps-3">{{ $order->cancel_reason }}</i>
        </div>
    @break

    @default
@endswitch
