<div class="card">
    <div class="card-header">
        <h6 class="text-center">{{ trans('labels.shipping_info') }}</h6>
    </div>
    <div class="card-body pt-0">
        {!! Form::model($order, [
            'url' => route('admin.order.accept', $order->id),
            'method' => 'PUT',
            'class' => 'accept-order-form'
        ]) !!}
        <div>
            {!! Form::label('pickup_address_id', trans('labels.pickup_address') . ': ', [
                'class' => 'custom-label-control m-0',
            ]) !!}
            <div>
                {!! Form::select('pickup_address_id', pickUpAddressOptions(), [$pickup_addresses->where('featured', 1)->first()->id], ['class' => 'select2']) !!}
            </div>
        </div>
        <div class="mt-3">
            {!! Form::label('pickup_shift_id', trans('labels.pickup_shift') . ': ', [
                'class' => 'custom-label-control m-0',
            ]) !!}
            <div>
                {!! Form::select('pickup_shift_id', $pickup_shifts, [], ['class' => 'select2']) !!}
            </div>
        </div>
        <div class="order-shipping-info-label mt-3">
            <label for="address-fullname">Tên</label>
            <span class="address-fullname text-sm"></span>
        </div>
        <div class="order-shipping-info-label">
            <label for="address-phone">Số điện thoại</label>
            <span class="address-phone text-sm"></span>
        </div>
        <div class="order-shipping-info-label">
            <label for="address-full">Địa chỉ</label>
            <span class="address-full text-sm"></span>
        </div>
        <div class="text-end">
            {!! Form::submit(trans('labels.accept'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}

    </div>
</div>
<script>
    (() => {
        const pickup_addresses = @json($pickup_addresses);
        const initPickUpAddressInfo = (pickup_address_id) => {
            const pickup_address = pickup_addresses.find(e => {
                return e.id == pickup_address_id
            })
            $('.address-fullname').text(pickup_address.fullname)
            $('.address-phone').text(pickup_address.phone)
            $('.address-full').text(pickup_address.full_address)
        }
        $('select[name=pickup_address_id]').on('change', (e) => {
            const pickup_address_id = e.target.value;
            initPickUpAddressInfo(pickup_address_id)
        })
        initPickUpAddressInfo($('select[name=pickup_address_id]').val())
        $('.accept-order-form').ajaxForm({
            beforeSend: () => {
                $('input[type=submit]').loading()
            },
            success: (res) => {
                toast.success(`{{trans('toast.action_successful')}}`, res.data.message)
                $('.modal.show').modal('hide')
                if (typeof orderTable !== 'undefined') {
                    orderTable.ajax.reload()
                } else {
                    window.location.reload()
                }
            },
            error: (err) => {
                tata.error(`{{trans('toast.action_failed')}}`, err.responseJSON.message);
                $('input[type=submit]').loading(false)
            }
        })
    })()
</script>
