<x-admin.card header="Thông tin bổ sung" cardClass="mt-3 product-step" id="additional-info-step">
    <div class="row">
        <div class="col-md-2">
            {!! Form::label('description', 'Mô tả', ['class' => 'custom-control-label label-required']) !!}
        </div>
        <div class="col-md-10">
            {!! Form::textarea('description', null, [
                'class' => 'form-control summernote',
                'required',
                'data-v-min-length' => 100,
                'placeholder' => 'Thông tin mô tả sản phẩm',
            ]) !!}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-2">
            {!! Form::label('shipping_and_return', 'Vận chuyển và trả hàng', ['class' => 'custom-control-label label-required']) !!}
        </div>
        <div class="col-md-10">
            {!! Form::textarea('shipping_and_return', null, [
                'class' => 'form-control summernote',
                'required',
                'data-v-min-length' => 100,
                'data-v-max-length' => 1000,
                'placeholder' => 'Hướng dẫn vận chuyển và trả hàng',
            ]) !!}
        </div>
    </div>
    {{-- <div class="row mt-3">
        <div class="col-md-2">
            {!! Form::label('additional_information', 'Thông tin thêm', ['class' => 'custom-control-label label-required']) !!}
        </div>
        <div class="col-md-10">
            {!! Form::textarea('additional_information', null, [
                'class' => 'form-control summernote',
                'placeholder' => 'Quy cách chọn số đo, kích cỡ,..',
            ]) !!}
        </div>
    </div> --}}
</x-admin.card>
