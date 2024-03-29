@include('admin.pages.accom-product.assets._style')
<div class="card">
    <div class="card-header d-flex justify-content-between pb-0">
        <h6>Thông tin cơ bản</h6>
    </div>
    <div class="card-body pt-0">
        <div class="row">
            <div class="col-md-6">

                <div class="row">
                    <div class="col-md-4">
                        {!! Form::label('name', 'Tên chương trình khuyến mãi:', ['class' => 'custom-control-label m-0']) !!}
                    </div>
                    <div class="col-md-8">
                        {!! Form::hidden('id', null, []) !!}
                        {!! Form::text('name', null, [
                            'placeholder' => 'Nhập tên chương trình',
                            'class' => 'form-control',
                            'required',
                            'data-v-min-length' => '10',
                            'autoComplete' => 'off',
                        ]) !!}
                    </div>
                </div>
                {!! Form::hidden('type', App\Enums\PromotionType::ACCOM_PRODUCT, []) !!}
                <div class="row mt-3">
                    <div class="col-md-4 d-flex vertical-align-center">
                        {!! Form::label('from', 'Thời gian khuyến mãi:', ['class' => 'custom-control-label m-0']) !!}
                    </div>
                    <div class="col-md-8 d-flex justify-content-between">
                        <div class="input-group" style="height: fit-content">
                            <span class="input-group-text" id="basic-addon2"><i
                                    class="ni ni-calendar-grid-58"></i></span>
                            {!! Form::text('from', null, [
                                'class' => 'form-control datetimepicker',
                                'data-v-before' => 'to',
                                'placeholder' => 'Chọn ngày',
                                'required',
                            ]) !!}
                        </div>
                        <span class="horizontal-split"></span>
                        <div class="input-group" style="height: fit-content">
                            <span class="input-group-text" id="basic-addon2"><i
                                    class="ni ni-calendar-grid-58"></i></span>
                            {!! Form::text('to', null, [
                                'class' => 'form-control datetimepicker',
                                'data-v-after' => 'from',
                                'placeholder' => 'Chọn ngày',
                                'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        {!! Form::label('num_of_products', 'Số lượng sản phẩm được tặng:', ['class' => 'lh-base     custom-control-label m-0']) !!}
                    </div>
                    <div class="col-md-8">
                        {!! Form::number('num_of_products', isset($promotion) ?  $promotion->num_of_products : null, ['class' => 'form-control', 'placeholder' => 'Số lượng sản phẩm được tặng', 'required', 'data-v-min' => 1]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mt-3">
    <div class="card-header d-flex justify-content-between pb-0">
        <h6>Thêm sản phẩm tặng kèm</h6>
        <a href="#" class="btn btn-primary ajax-modal-btn"
            data-link="{{ route('admin.combo.modal.product') }}">Thêm sản phẩm</a>
    </div>
    <div class="card-body pt-0">
        <div class="promotion-setting-header row">
            <div class="col-3">
                <h6>Thiết lập hàng loạt</h6>
                <div><strong id="numberOfCheckedProducts">0</strong> Sản phẩm đã chọn</div>
            </div>
            <div class="col-2">
                <label for="">Số lương sản phẩm tặng mỗi đơn hàng</label>
                <div class="input-group height-fit-content">
                    <input min="1" max="100" type="number" class="form-control"
                        name="general-quantity-each-order" onfocus="focused(this)" onfocusout="defocused(this)">
                </div>
            </div>
            <div class="offset-4 col-2 d-flex justify-content-center align-items-center">
                <button class="btn btn-default common-info-update-btn">Cập nhật hàng loạt</button>
            </div>
            <div class="col-1 d-flex justify-content-center align-items-center">
                <button type="button" id="batch-delete-btn" class="btn btn-default">Xoá</button>
            </div>
        </div>
        <div class="promotion-setting-header row mt-3">
            @include('admin.pages.accom-product.components.promotion-table-header')
        </div>
        <div class="promotion-setting-wrapper">
        </div>
    </div>
    <div class="card-footer text-end">
        <button class="btn btn-primary" id="promotion-update-btn">{{ trans('labels.update') }}</button>
    </div>
</div>
