<div class="form-group">
    <label for="example-text-input" class="form-control-label">{{ trans('labels.category_name') }}</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào']) !!}
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
