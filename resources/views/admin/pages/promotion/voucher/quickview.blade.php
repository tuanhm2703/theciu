<div class="card voucher-info-container">
    <div class="card-header">
        <h6>{{ trans('labels.voucher_details') }}</h6>
    </div>
    <div class="card-body pt-0">
        {!! Form::model($voucher, [
            'id' => 'quick-view-form'
        ]) !!}
        <div class="card mb-4 container">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>{{ isset($voucher) ? trans('labels.edit_voucher') : trans('labels.create_voucher') }}</h6>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <div class="col-4 col-md-4 d-flex align-items-center justify-content-end">
                        {!! Form::label('voucher_type_id', 'Loại khuyến mãi:', ['class' => 'custom-control-label']) !!}
                    </div>
                    <div class="col-8 col-md-8">
                        @foreach ($voucher_types as $type)
                            <article class="feature1">
                                {!! Form::radio('voucher_type_id', $type->id, true, ['id' => "radio-btn-$type->id"]) !!}
                                <div class="d-flex justify-content-evenly">
                                    <i class="ni ni-basket text-primary"></i>
                                    <span class="text-bold text-dark pl-3">Voucher đơn hàng</span>
                                </div>
                                <div class="check-icon">
                                    <div class="icon-ctn"><i class="the-ciu-icon icons"><svg
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                                <path
                                                    d="M4.03 7.47a.75.75 0 00-1.06 1.06l3.358 3.359a.75.75 0 001.06 0l5.863-5.862a.75.75 0 00-1.061-1.06l-5.332 5.33L4.03 7.47z">
                                                </path>
                                            </svg></i></div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 col-md-4 vertical-align-center justify-content-end">
                        {!! Form::label('name', 'Tên chương trình:', ['class' => 'm-0 custom-control-label']) !!}
                    </div>
                    <div class="col-8 col-md-8">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 col-md-4 vertical-align-center justify-content-end">
                        {!! Form::label('code', 'Mã voucher:', ['class' => 'custom-control-label m-0']) !!}
                    </div>
                    <div class="col-8 col-md-8">
                        {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 col-md-4 vertical-align-center justify-content-end">
                        {!! Form::label('begin', 'Thời gian sử dụng mã', ['class' => 'm-0 custom-control-label']) !!}
                    </div>
                    <div class="col-8 col-md-8 d-flex">
                        {!! Form::datetime('begin', null, [
                            'class' => 'form-control datetimepicker me-3',
                            'required',
                            'placeholder' => 'Chọn ngày bắt đầu',
                        ]) !!}
                        {!! Form::datetime('end', null, [
                            'class' => 'form-control datetimepicker',
                            'required',
                            'placeholder' => 'Chọn ngày kết thúc',
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="card container">
            <div class="card-header">
                <h6>Thiết lập mã giảm giá</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <div class="col-4 col-md-4 vertical-align-center justify-content-end">
                        {!! Form::label('discount_type', 'Loại giảm giá | Mức giảm:', ['class' => 'm-0 custom-control-label text-end']) !!}
                    </div>
                    <div class="col-8 col-md-8 d-flex">
                        {!! Form::select(
                            'discount_type',
                            App\Enums\VoucherDiscountType::getDiscountTypeOptions(),
                            [],
                            ['class' => 'select2 form-control'],
                        ) !!}
                        {!! Form::number('value', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 col-md-4 text-end">
                        {!! Form::label('max_discount', 'Mức giảm tối đa:', ['class' => 'm-0 custom-control-label']) !!}
                    </div>
                    <div class="col-6 col-md-6 d-flex justify-content-between">
                        <div class="form-check mb-3">
                            {!! Form::radio('is_limit_max_discount', 1, true, ['class' => 'form-check-input']) !!}
                            {!! Form::label('is_limit_max_discount', 'Giới hạn', ['class' => 'custom-control-label']) !!}

                        </div>
                        <div class="form-check">
                            {!! Form::radio('is_limit_max_discount', 0, false, ['class' => 'form-check-input']) !!}
                            {!! Form::label('is_limit_max_discount', 'Không giới hạn', ['class' => 'custom-control-label']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-4 offset-md-4 col-8 col-md-4">
                        {!! Form::text('max_discount_amount', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào']) !!}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 col-md-4 vertical-align-center justify-content-end">
                        {!! Form::label('min_order_value', 'Giá trị đơn hàng tối thiểu:', ['class' => 'custom-control-label m-0']) !!}
                    </div>
                    <div class="col-8 col-md-8">
                        {!! Form::number('min_order_value', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 col-md-4 vertical-align-center justify-content-end">
                        {!! Form::label('quantity', 'Lượt sử dụng tối đa:', ['class' => 'custom-control-label m-0']) !!}
                    </div>
                    <div class="col-8 col-md-8">
                        {!! Form::number('quantity', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 col-md-4 vertical-align-center justify-content-end">
                        {!! Form::label('customer_limit', 'Lượt sử dụng tối đa/Người mua:', [
                            'class' => 'custom-control-label m-0 text-end',
                        ]) !!}
                    </div>
                    <div class="col-8 col-md-8">
                        {!! Form::number('customer_limit', 1, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script>
    $('#quick-view-form input, #quick-view-form select, #quick-view-form').attr('disabled', true);
</script>
