<div class="dropdown text-center">
    <button class="btn dropdown-toggle m-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        style="box-shadow: none" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
        <li>
            <a href="{{ route('admin.product.edit', $product->id) }}" class="dropdown-item"><span
                    class="badge badge-warning d-block text-warning"><i
                        class="far fa-edit p-1"></i>{{ trans('labels.edit') }}</span></a>
        </li>
        <li>
            {!! Form::open([
                'url' => route('admin.product.fix', $product->id),
                'method' => 'POST',
                'class' => 'ajax-form',
            ]) !!}
            <button type="submit" class="dropdown-item ajax-confirm"><span
                    class="badge badge-warning d-block text-warning"><i class="fas fa-cog p-1"></i>Fix</span></button>
            {!! Form::close() !!}
        </li>
        <li>
            {!! Form::open([
                'url' => route('admin.product.destroy', $product->id),
                'method' => 'DELETE',
                'class' => 'ajax-form',
            ]) !!}
            <button type="submit" class="dropdown-item ajax-confirm"><span
                    class="badge badge-danger d-block text-danger"><i
                        class="fas fa-trash p-1"></i>{{ trans('labels.delete') }}</span></button>
            {!! Form::close() !!}
        </li>
    </ul>
</div>

<script>
    $('.ajax-form').ajaxForm({
        success: (res) => {
            table.ajax.reload()
            toast.success('{{ trans('toast.action_successful') }}', res.data.message)
        }
    })
</script>
