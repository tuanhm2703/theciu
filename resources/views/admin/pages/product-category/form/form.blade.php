<div class="form-group">
    <div class="form-group">
        <label for="example-text-input" class="form-control-label">{{ trans('labels.category_name') }}</label>
        <div class="input-group">
            <span class="input-group-text">
                {!! Form::select(
                    'type',
                    App\Enums\CategoryType::productCategoryTypeOptions(),
                    [isset($category) ? $category->type : null],
                    ['class' => 'form-control'],
                ) !!}
            </span>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào']) !!}
        </div>
    </div>
    <div>
        <label for="visible" class="form-control-label">Hiển thị</label>
        <div class="form-check form-switch">
            {!! Form::checkbox('visible', null, isset($category) ? $category->visible : true, ['class' => 'form-check-input']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('meta[keywords]', 'Meta-keywords', ['class' => 'form-label']) !!}
        {!! Form::text('meta[keywords]', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('meta[description]', 'Meta-description', ['class' => 'form-label']) !!}
        {!! Form::textarea('meta[description]', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('meta[title]', 'Meta-title', ['class' => 'form-label']) !!}
        {!! Form::text('meta[title]', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('content', trans('labels.content'), ['class' => 'form-label']) !!}
        {!! Form::textarea('content', null, ['class' => 'form-control summernote']) !!}
    </div>
</div>
<script>
    (() => {
        $('input[name=parent_id]').val(parentId)
        $('.category-form').ajaxForm({
            beforeSend: () => {
                $('.submit-btn').loading()
            },
            success: (res) => {
                toast.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                setTimeout(() => {
                    window.location.reload()
                }, 1000);
            },
            error: (err) => {
                $('.submit-btn').loading(false)
            }
        })
    })()
</script>
