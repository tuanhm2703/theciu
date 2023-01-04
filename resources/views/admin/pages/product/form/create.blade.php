<div class="position-relative">
    {!! Form::open([
        'url' => route('admin.product.store'),
        'method' => 'POST',
        'class' => 'product-form needs-validation',
        'novalidate',
    ]) !!}
    @include('admin.pages.product.form.form')
    <div class="card mt-3 fixed-bottom" style="width: 83%;left: 15.5%;    bottom: 1rem;">
        <div class="card-body text-end pt-0 pb-0 position-relative">
            <div class="product-submit-error-tip d-none">
                <i class="text-warning fas fa-exclamation-triangle"></i> <span class="product-number-of-invalidate">Có 0 lỗi</span> <a
                    href="#" class="text-bold fix-now-btn">Chỉnh sửa ngay</a>
            </div>
            {!! Form::submit('Tạo sản phẩm', ['class' => 'btn btn-primary mt-3', 'style' => 'z-index: 1']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
