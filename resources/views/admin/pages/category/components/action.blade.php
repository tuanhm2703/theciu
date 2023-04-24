<div class="dropdown text-center">
    <button class="btn dropdown-toggle m-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        style="box-shadow: none" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li>
            <a class="btn btn-link text-dark px-3 mb-0 ajax-modal-btn" href="javascript:;" data-init-app="false"
                data-link="{{ route('admin.category.edit', $category->id) }}">Chỉnh sửa</a>
        </li>
        <li>
            <button class="btn btn-link text-dark px-3 mb-0 ajax-modal-btn" href="javascript:;" data-init-app="false"
                data-link="{{ route('admin.ajax.category.view.add_product', ['category' => $category->id]) }}">Thêm sản phẩm</button>

        </li>
        <li>
            {!! Form::model($category, [
                'url' => route('admin.category.destroy', $category->id),
                'method' => 'DELETE',
                'class' => 'ajax-form'
            ]) !!}
            <button class="btn btn-link text-dark px-3 mb-0 ajax-confirm" href="javascript:;" data-init-app="false">{{ trans('labels.delete') }}</button>
            {!! Form::close() !!}
        </li>
    </ul>
</div>
<script>
    $('.ajax-form').ajaxForm({
        success: (res) => {
            categoryTable.ajax.reload()
            toast.success('{{ trans('toast.action_successful') }}', res.data.message)
        }
    })
</script>
