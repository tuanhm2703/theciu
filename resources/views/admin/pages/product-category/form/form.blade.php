<div class="form-group">
    <div class="form-group">
        <label for="example-text-input" class="form-control-label">{{ trans('labels.category_name') }}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('meta[description]', 'Meta-description', ['class' => 'form-label']) !!}
        {!! Form::textarea('meta[description]', null, ['class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('meta[title]', 'Meta-title', ['class' => 'form-label']) !!}
        {!! Form::text('meta[title]', null, ['class' => 'form-control']) !!}
    </div>
    {!! Form::hidden('parent_id', null, []) !!}
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
                tata.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                categoryTable.ajax.reload()
                initTreeview()
                $('.category-form').parents('.modal').modal('hide')
            },
            error: (err) => {
                $('.submit-btn').loading(false)
            }
        })
    })()
</script>
