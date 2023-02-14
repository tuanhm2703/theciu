<x-admin.card header="Thông tin khác" cardClass="mt-3 product-step" id="other-info-step">
    <div class="row">
        <div class="col-md-2">
            {!! Form::label('is_reorder', 'Hàng đặt trước:', ['class' => 'custom-control-label']) !!}
        </div>
        <div class="col-lg-2 col-sm-5 d-flex justify-content-between">
            <div class="form-check mb-3">
                {!! Form::radio('is_reorder', 0, null, ['class' => 'form-check-input']) !!}
                {!! Form::label('is_reorder', 'Không', ['class' => 'custom-control-label']) !!}
            </div>
            <div class="form-check">
                {!! Form::radio('is_reorder', 1, null, ['class' => 'form-check-input']) !!}
                {!! Form::label('is_reorder', 'Đồng ý', ['class' => 'custom-control-label']) !!}
            </div>
        </div>
    </div>
    <div class="row d-none" id="reorder-day-selector">
        <div class="offset-md-2">
            <div>Tôi cần
                {!! Form::number('reorder_days', null, ['class' => 'form-control d-inline', 'style' => 'width: 60px', 'min' => 7, 'max' => 15]) !!}
                thời gian chuẩn bị hàng (tối thiểu: 7 ngày - tối đa: 15 ngày)
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-2">
            {!! Form::label('condition', 'Tình trạng:', ['class' => 'custom-control-label']) !!}
        </div>
        <div class="col-lg-2 col-sm-5">
            {!! Form::select(
                'condition',
                ['1' => 'Mới', '2' => 'Cũ'],
                [isset($product) ? $product->condition : 1],
                ['class' => 'form-control select2', 'required'],
            ) !!}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-2">
            {!! Form::label('sku', 'SKU sản phẩm:', ['class' => 'custom-control-label']) !!}
        </div>
        <div class="col-md-2">
            {!! Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào']) !!}
        </div>
    </div>
</x-admin.card>
