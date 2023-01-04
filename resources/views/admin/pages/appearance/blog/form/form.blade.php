<div class="card mx-3">
    <div class="card-header pb-0">
        <h6 class="text-uppercase">Thông tin chung</h6>
    </div>
    <div class="card-body pt-0">
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('title', trans('labels.title') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào', 'required']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('publish_date', trans('labels.publish_date') . ': ', ['class' => 'custom-control-label']) !!}
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon2"><i class="ni ni-calendar-grid-58"></i></span>
                    {!! Form::text('publish_date', \Carbon\Carbon::now(), [
                        'class' => 'form-control datetimepicker',
                        'placeholder' => 'Nhập vào',
                        'required',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                {!! Form::label('description', trans('labels.description') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Nhập vào',
                    'required',
                    'rows' => '5',
                ]) !!}
            </div>
        </div>
    </div>
</div>
<div class="card mx-3 mt-3">
    <div class="card-header pb-0">
        <h6 class="text-uppercase">Thông tin chi tiết</h6>
    </div>
    <div class="card-body pt-0">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::label('category_ids[]', trans('labels.category') . ': ', [
                            'class' => 'custom-control-label',
                        ]) !!}
                    </div>
                    <div class="col-md-8 position-relative">
                        {!! Form::select('category_ids[]', isset($selected) ? $selected : [], isset($blog) ? $blog->category_ids : [], [
                            'class' => 'select2-ajax',
                            'multiple' => 'multiple',
                            'required',
                            'data-select2-url' => route('admin.ajax.category.search', ['type' => App\Enums\CategoryType::BLOG]),
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::label('status', trans('labels.status') . ': ', ['class' => 'custom-control-label']) !!}
                    </div>
                    <div class="col-md-8 vertical-align-center">
                        <div class="form-check form-switch">
                            {!! Form::checkbox('status', null, null, ['class' => 'form-check-input']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('image', trans('labels.image') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::file('image', ['class' => 'd-block filepond', 'data-label' => 'Chọn file', 'required']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('content', trans('labels.content') . ': ', ['class' => 'custom-control-label']) !!}
                {!! Form::textarea('content', null, [
                    'class' => 'form-control summernote',
                    'placeholder' => 'Nhập vào',
                    'required',
                ]) !!}
            </div>
        </div>
    </div>
</div>
