<div class="dropdown text-center">
    <button class="btn dropdown-toggle m-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        style="box-shadow: none" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
        <li>
            <a href="#" class="ajax-modal-btn dropdown-item"
            data-link="{{ route('admin.rank.edit', $rank->id) }}"><span
                class="badge badge-warning d-block text-warning"><i
                    class="far fa-edit p-1"></i>{{ trans('labels.edit') }}</span></a>
        </li>
    </ul>
</div>

<script>
    $('.ajax-form').ajaxForm({
        success: (res) => {
            table.ajax.reload()
            tata.success('{{ trans('toast.action_successful') }}', res.data.message)
        }
    })
</script>
