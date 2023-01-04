<div class="dropdown text-center">
    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        style="box-shadow: none" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
        <li>
            <a href="#" class="ajax-modal-btn dropdown-item" data-callback='initEditForm(@json($blog))'
                data-link="{{ route('admin.appearance.blog.edit', $blog->id) }}"><span
                    class="badge badge-warning d-block text-warning"><i
                        class="far fa-edit p-1"></i>{{ trans('labels.edit') }}</span></a>
        </li>
        <li>
            {!! Form::open([
                'url' => route('admin.appearance.blog.destroy', $blog->id),
                'method' => 'DELETE',
                'class' => 'ajax-form',
            ]) !!}
            <button type="submit" data-content="Bạn có muốn xoá blog này?"  class="dropdown-item ajax-confirm"><span
                    class="badge badge-danger d-block text-danger"><i
                        class="fas fa-trash p-1"></i>{{ trans('labels.delete') }}</span></button>
            {!! Form::close() !!}
        </li>
    </ul>
</div>

<script>
    $('.ajax-form').ajaxForm({
        success: (res) => {
            blogTable.ajax.reload()
            tata.success('{{ trans('toast.action_successful') }}', res.data.message)
        }
    })
</script>
