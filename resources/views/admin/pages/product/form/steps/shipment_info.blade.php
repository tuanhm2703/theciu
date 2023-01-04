<x-admin.card header="Vận chuyển" cardClass="mt-3 product-step" id="shipment-info-step">
    <div class="row">
        <div class="col-md-2">
            {!! Form::label('weight', 'Cân nặng (Sau khi đóng gói)', ['class' => 'custom-control-label label-required']) !!}
        </div>
        <div class="col-md-3">
            <div>
                <div class="input-group">
                    {!! Form::number('weight', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Nhập vào',
                        'required',
                    ]) !!}
                    <span class="input-group-text" id="basic-addon2"><span
                            class="before-prefix-split"></span>gr</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-2">
            {!! Form::label(
                'package_info',
                'Kích thước đóng gòi (Phí vận chuyển thực tế sẽ thay đổi nếu bạn nhập sai kích thước)',
                ['class' => 'custom-control-label label-required'],
            ) !!}
        </div>
        <div class="col-md-3 mt-3 mt-md-0">
            <div class="input-group">
                {!! Form::number('width', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
                <span class="input-group-text" id="basic-addon2"><span class="before-prefix-split"></span>cm</span>
            </div>
        </div>
        <div class="col-md-3 mt-3 mt-md-0">
            <div class="input-group">
                {!! Form::number('length', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'data-v-required']) !!}
                <span class="input-group-text" id="basic-addon2"><span class="before-prefix-split"></span>cm</span>
            </div>
        </div>
        <div class="col-md-3 mt-3 mt-md-0">
            <div class="input-group">
                {!! Form::number('height', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'data-v-required']) !!}
                <span class="input-group-text" id="basic-addon2"><span class="before-prefix-split"></span>cm</span>
            </div>
        </div>
    </div>
</x-admin.card>
