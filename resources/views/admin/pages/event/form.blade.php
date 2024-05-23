
<div class="row">
    <div class="col-md-6">
        {!! Form::label('name', trans('labels.name') . ': ', ['class' => 'custom-label-control m-0']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('image', trans('labels.image'), ['class' => 'custom-label-control m-0']) !!}
            {!! Form::file('image', ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        {!! Form::label('from', trans('labels.from_date'), ['class' => 'custom-label-control']) !!}
        {!! Form::text('from', null, ['class' => 'form-control datetimepicker']) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('to', trans('labels.to_date'), ['class' => 'custom-label-control']) !!}
        {!! Form::text('to', null, ['class' => 'form-control datetimepicker']) !!}
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        {!! Form::label('content', trans('labels.content') . ': ', ['class' => 'custom-label-control']) !!}
        {!! Form::textarea('content', null, [
            'class' => 'form-control summernote',
            'placeholder' => 'Nhập vào',
            'rows' => 5,
        ]) !!}
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        {!! Form::label('image_section', trans('labels.image_section') . ': ', ['class' => 'custom-label-control']) !!}
        {!! Form::textarea('image_section', null, [
            'class' => 'form-control summernote',
            'placeholder' => 'Nhập vào',
            'rows' => 5,
        ]) !!}
    </div>
</div>

<div class="mt-3">
    {!! Form::label('image_section', 'Sản phẩm đi kèm: ', ['class' => 'custom-label-control']) !!}
    <table class="product-table table w-100">
        <thead>
            <th style="padding-left: 0.5rem">
            </th>
            <th>{{ trans('labels.product_name') }}</th>
            <th>{{ trans('labels.price') }}</th>
            <th>{{ trans('labels.warehouse') }}</th>
        </thead>
        <tbody></tbody>
    </table>
    <div class="text-end mt-3"><button class="btn btn-primary submit-btn" id="add-product-btn">Thêm sản
            phẩm</button></div>
</div>
