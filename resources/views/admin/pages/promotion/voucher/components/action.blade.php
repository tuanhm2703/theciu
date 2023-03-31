<div class="dropdown text-center">
    <button class="btn dropdown-toggle m-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        style="box-shadow: none" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
        <li>
            <a href="{{ route('admin.promotion.voucher.edit', $voucher->id) }}" class="dropdown-item"><span
                    class="badge badge-warning d-block text-warning"><i
                        class="far fa-edit p-1"></i>{{ trans('labels.edit') }}</span></a>
        </li>
        <li>
            {!! Form::open([
                'url' => route('admin.promotion.voucher.destroy', $voucher->id),
                'method' => 'DELETE',
                'class' => 'ajax-form',
                ]) !!}
            <button type="submit" class="dropdown-item ajax-confirm"><span
                class="badge badge-danger d-block text-danger"><i
                class="fas fa-trash p-1"></i>{{ trans('labels.delete') }}</span></button>
                {!! Form::close() !!}
            </li>
            <li>
                <a href="#" class="ajax-modal-btn dropdown-item"
                    data-link="{{ route('admin.promotion.voucher.quickview', $voucher->id) }}"><span
                        class="badge badge-default d-block text-dark">
                        <i class="fas fa-eye p-1"></i>{{ trans('labels.details') }}</span></a>
            </li>
        </ul>
    </div>

<script>
    $('.ajax-form').ajaxForm({
        success: (res) => {
            voucherTable.ajax.reload()
            voucherTable.success('{{ trans('toast.action_successful') }}', res.data.message)
        }
    })
</script>
