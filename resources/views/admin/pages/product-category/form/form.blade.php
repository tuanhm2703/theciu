<div class="form-group">
    <div class="form-group">
        <label for="example-text-input" class="form-control-label">{{ trans('labels.category_name') }}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào']) !!}
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
    {!! Form::hidden('type', App\Enums\CategoryType::PRODUCT, []) !!}
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
                categoryTable.ajax.reload()
                initTreeview()
                $('.modal.show').modal('hide')
            },
            error: (err) => {
                $('.submit-btn').loading(false)
            }
        })
    })()
</script>
