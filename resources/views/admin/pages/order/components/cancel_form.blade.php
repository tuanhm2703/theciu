<div class="card">
    <div class="card-header">
        <h5 class="text-center text-uppercase">{{ trans('labels.cancel_order') }}</h5>
    </div>
    <div class="card-body pt-0">
        {!! Form::open([
            'url' => route('admin.order.cancel', $order->id),
            'method' => 'PUT',
            'class' => 'cancel-order-form',
        ]) !!}
        {!! Form::label('cancel_reason', trans('labels.cancel_reason') . ': ', ['class' => 'custom-label-control mb-1']) !!}
        <div class="form-check">
            {!! Form::radio('cancel_reason', trans('order.cancel_reasons.out_of_stock'), null, ['id' => 'cancelReason1']) !!}
            <label class="form-check-label" for="cancelReason1">
                {{ trans('order.cancel_reasons.out_of_stock') }}
            </label>
        </div>
        <div class="form-check">
            {!! Form::radio('cancel_reason', trans('order.cancel_reasons.cannot_prepare_in_time'), null, [
                'id' => 'cancelReason2',
            ]) !!}
            <label class="form-check-label" for="cancelReason2">
                {{ trans('order.cancel_reasons.cannot_prepare_in_time') }}
            </label>
        </div>
        <div class="form-check">
            {!! Form::radio('cancel_reason', trans('order.cancel_reasons.shipping_address_invalid'), null, [
                'id' => 'cancelReason3',
            ]) !!}
            <label class="form-check-label" for="cancelReason3">
                {{ trans('order.cancel_reasons.shipping_address_invalid') }}
            </label>
        </div>
        <div class="form-check">
            {!! Form::radio('cancel_reason', trans('order.cancel_reasons.other'), null, ['id' => 'cancelReason4']) !!}
            <label class="form-check-label" for="cancelReason4">
                {{ trans('order.cancel_reasons.other') }}
            </label>
            <textarea placeholder="Nhập lý do" class="d-none form-control" name="other_reason" id="" cols="30" rows="3"></textarea>
        </div>
        <div class="text-end mt-3">
            <button class="btn btn-primary submit-btn">{{ trans('labels.cancel_order') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script>
    (() => {
        $('input[name=cancel_reason]').on('change', (e) => {
            if($(e.target).attr('id') == 'cancelReason4') {
                $('textarea[name=other_reason]').removeClass('d-none');
            } else {
                $('textarea[name=other_reason]').val('')
                $('textarea[name=other_reason]').addClass('d-none');
            }
        })
        $('.cancel-order-form').ajaxForm({
            beforeSend: () => {
                $('.submit-btn').loading()
            },
            success: (res) => {
                toast.success(@json(trans('toast.action_successful')), res.data.message);
                setTimeout(() => {
                    window.location.reload()
                }, 1000);
            },
            error: (error) => {
                tata.error(@json(trans('toast.action_failed')), error.responseJSON.message)
                $('.submit-btn').loading(false)
            }
        })
    })()
</script>
