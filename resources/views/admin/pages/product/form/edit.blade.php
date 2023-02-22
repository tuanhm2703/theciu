<div class="position-relative">
    {!! Form::model($product, [
        'route' => ['admin.product.update', $product->id],
        'method' => 'PUT',
        'class' => 'product-form novalidate',
    ]) !!}
    @include('admin.pages.product.form.form')
    <div class="card mt-3 position-sticky bottom-0">
        <div class="card-body text-end pt-0 pb-0">
            <div class="product-submit-error-tip d-none">
                <i class="text-warning fas fa-exclamation-triangle"></i> <span class="product-number-of-invalidate">Có 0 lỗi</span> <a
                    href="#" class="text-bold">Chỉnh sửa ngay</a>
            </div>
            <button class="btn btn-primary mt-3 submit-btn" type="submit" style="z-index: 1">{{ trans('labels.update') }}</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@push('js')
    @include('admin.pages.product.form.assets._edit_script')
@endpush
