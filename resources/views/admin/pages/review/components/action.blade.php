<div class="dropdown text-center">
    <button class="btn dropdown-toggle m-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        style="box-shadow: none" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
        @if ($review->status === App\Enums\StatusType::ACTIVE)
            <li>
                {!! Form::open([
                    'url' => route('admin.review.deactive', $review->id),
                    'method' => 'PUT',
                    'class' => 'ajax-form',
                ]) !!}
                <button type="submit" class="dropdown-item ajax-confirm"><span
                        class="badge badge-danger d-block text-danger"><i
                            class="fas fa-trash p-1"></i>Ẩn</span></button>
                {!! Form::close() !!}
            </li>
        @else
            <li>
                {!! Form::open([
                    'url' => route('admin.review.active', $review->id),
                    'method' => 'PUT',
                    'class' => 'ajax-form',
                ]) !!}
                <button type="submit" class="dropdown-item ajax-confirm"><span
                        class="badge badge-success d-block text-success"><i
                            class="fas fa-eye p-1"></i>Hiện</span></button>
                {!! Form::close() !!}
            </li>
        @endif
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
