<div class="form-group">
    <label for="example-text-input" class="form-control-label">{{ trans('labels.category_name') }}</label>
    <div class="input-group">
        <span class="input-group-text">
            {!! Form::select('type', App\Enums\CategoryType::categoryTypeOptions(), [isset($category) ? $category->type : null], ['class' => 'form-control']) !!}
        </span>
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nhập vào']) !!}
    </div>
</div>
<div class="form-group">
    <input type="file" name="image">
</div>
<script>
    $('.category-form').ajaxForm({
        beforeSend: () => {
            $('.submit-btn').loading()
        },
        success: (res) => {
            tata.success(`{{ trans('toast.action_successful') }}`, res.data.message)
            categoryTable.ajax.reload()
            $('.category-form').parents('.modal').modal('hide')
        },
        error: (err) => {
            $('.submit-btn').loading(false)
        }
    })
</script>
