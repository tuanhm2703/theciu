@push('style')
    <style>
        article {
            position: relative;
            width: 192px;
            height: 64px;
            float: left;
            border: 1px solid lightgrey;
            box-sizing: border-box;
            border-radius: 4px;
        }

        article div {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            line-height: 25px;
            transition: .5s ease;
        }

        article input {
            position: absolute;
            top: 0;
            left: 0;
            width: 140px;
            height: 100px;
            opacity: 0;
            cursor: pointer;
        }

        input[type=radio]:checked~.check-icon {
            background-color: #ee4d2d;
        }

        .upgrade-btn {
            display: block;
            margin: 30px auto;
            width: 200px;
            padding: 10px 20px;
            border: 2px solid #50bcf2;
            border-radius: 50px;
            color: #f5f5f5;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            transition: .3s ease;
        }

        .upgrade-btn:hover {
            background-color: #50bcf2;
        }

        .blue-color {
            color: #50bcf2;
        }

        .gray-color {
            color: #555;
        }

        .social i:before {
            width: 14px;
            height: 14px;
            position: fixed;
            color: #fff;
            background: #0077B5;
            padding: 10px;
            border-radius: 50%;
            top: 5px;
            right: 5px;
        }

        @keyframes slidein {
            from {
                margin-top: 100%;
                width: 300%;
            }

            to {
                margin: 0%;
                width: 100%;
            }
        }

        .check-icon {
            width: 28px;
            height: 28px;
            position: absolute;
            border-top-right-radius: 4px;
            top: 0;
            right: 0;
            background-color: grey;
        }

        .icon-ctn {
            position: absolute;
            border-top: 28px solid transparent;
            border-left: 28px solid #fff;
            height: 0;
            width: 0;
        }

        .the-ciu-icon {
            width: 16px;
            height: 16px;
            fill: #fff;
            position: absolute;
            top: -32px;
            right: 0;
        }

        .select2-container--default .select2-selection--single {
            border-radius: 0;
            border: 1px solid #d2d6da;
            border-right: 0;
            height: 100%;
        }

        input[name=value] {
            border-radius: 0;
        }

        .select2-container {
            height: 100%;
        }

        .selection {
            height: 100%;
        }
        .custom-control-label {
            line-height: 1rem;
        }
    </style>
@endpush
<div class="card mb-4 container">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
            <h6>{{ trans('labels.create_voucher') }}</h6>
        </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="row">
            <div class="col-4 col-lg-2 d-flex align-items-center justify-content-end">
                {!! Form::label('voucher_type_id', 'Loại khuyến mãi:', ['class' => 'custom-control-label']) !!}
            </div>
            <div class="col-8 col-lg-10">
                @foreach ($voucher_types as $type)
                    <article class="feature1">
                        {!! Form::radio('voucher_type_id', $type->id, true, ['id' => "radio-btn-$type->id"]) !!}
                        <div class="d-flex justify-content-evenly">
                            <i class="ni ni-basket text-primary"></i>
                            <span class="text-bold text-dark pl-3">Voucher đơn hàng</span>
                        </div>
                        <div class="check-icon">
                            <div class="icon-ctn"><i class="the-ciu-icon icons"><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 16 16">
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
            <div class="col-4 col-lg-2 vertical-align-center justify-content-end">
                {!! Form::label('name', 'Tên chương trình:', ['class' => 'm-0 custom-control-label']) !!}
            </div>
            <div class="col-8 col-lg-4">
                {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4 col-lg-2 vertical-align-center justify-content-end">
                {!! Form::label('code', 'Mã voucher:', ['class' => 'custom-control-label m-0']) !!}
            </div>
            <div class="col-8 col-lg-4">
                {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4 col-lg-2 vertical-align-center justify-content-end">
                {!! Form::label('begin', 'Thời gian sử dụng mã', ['class' => 'm-0 custom-control-label']) !!}
            </div>
            <div class="col-8 col-lg-4 d-flex">
                {!! Form::date('begin', null, ['class' => 'form-control datepicker me-3', 'required', 'placeholder' => 'Chọn ngày bắt đầu']) !!}
                {!! Form::date('end', null, ['class' => 'form-control datepicker', 'required', 'placeholder' => 'Chọn ngày kết thúc']) !!}
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
            <div class="col-4 col-lg-2 vertical-align-center justify-content-end">
                {!! Form::label('discount_type', 'Loại giảm giá | Mức giảm:', ['class' => 'm-0 custom-control-label text-end']) !!}
            </div>
            <div class="col-8 col-lg-4 d-flex">
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
            <div class="col-4 col-lg-2 text-end">
                {!! Form::label('max_discount', 'Mức giảm tối đa:', ['class' => 'm-0 custom-control-label']) !!}
            </div>
            <div class="col-6 col-lg-3 d-flex justify-content-between">
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
            <div class="offset-4 offset-lg-2 col-8 col-lg-4">
                {!! Form::text('max_discount_amount', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4 col-lg-2 vertical-align-center justify-content-end">
                {!! Form::label('min_order_value', 'Giá trị đơn hàng tối thiểu:', ['class' => 'custom-control-label m-0']) !!}
            </div>
            <div class="col-8 col-lg-4">
                {!! Form::number('min_order_value', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4 col-lg-2 vertical-align-center justify-content-end">
                {!! Form::label('quantity', 'Lượt sử dụng tối đa:', ['class' => 'custom-control-label m-0']) !!}
            </div>
            <div class="col-8 col-lg-4">
                {!! Form::number('quantity', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4 col-lg-2 vertical-align-center justify-content-end">
                {!! Form::label('customer_limit', 'Lượt sử dụng tối đa/Người mua:', [
                    'class' => 'custom-control-label m-0 text-end',
                ]) !!}
            </div>
            <div class="col-8 col-lg-4">
                {!! Form::number('customer_limit', 1, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(".datepicker").flatpickr({
            enableTime: true,
        });
        $('input[name=is_limit_max_discount]').on('change', (e) => {
            if ($('input[name=max_discount_amount]').hasClass('d-none')) {
                $('input[name=max_discount_amount]').removeClass('d-none')
            } else {
                $('input[name=max_discount_amount]').addClass('d-none')
            }
        })
    </script>
@endpush
