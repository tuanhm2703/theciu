<div class="card card-plain">
    <div class="card-header pb-0 text-left">
        <h4 class="font-weight-bolder text-primary text-gradient">Thêm danh mục</h4>
    </div>
    <div class="card-body pb-3">
        {!! Form::open([
            'url' => route('admin.category.store'),
            'method' => 'POST',
            'class' => 'category-form',
            'enctype' => 'multipart/form-data',
        ]) !!}
        @include('admin.pages.product-category.form.form')
        <div class="text-end">
            <button class="btn btn-primary submit-btn">Tạo</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
