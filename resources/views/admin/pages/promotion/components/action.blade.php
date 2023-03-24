<div class="dropdown text-center">
    <button class="btn dropdown-toggle m-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        style="box-shadow: none" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </button>
    <ul class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
        @if (now()->between($promotion->from, $promotion->to))
            <li>
                <a href="{{ route('admin.promotion.edit', $promotion->id) }}" class="dropdown-item"><span
                        class="badge badge-warning d-block text-warning"><i
                            class="far fa-edit p-1"></i>{{ trans('labels.edit') }}</span></a>
            </li>
        @endif
        @if (now()->between($promotion->from, $promotion->to))
            <li>
                {!! Form::open([
                    'url' => route('admin.ajax.promotion.update.status', [
                        $promotion->id,
                        'status' => $promotion->isActive() ? App\Enums\StatusType::INACTIVE : App\Enums\StatusType::ACTIVE,
                    ]),
                    'method' => 'PUT',
                    'class' => 'ajax-form',
                ]) !!}
                <button type="submit" class="dropdown-item ajax-confirm"><span
                        class="badge d-block text-{{ $promotion->isActive() ? 'warning' : 'success' }}">
                        <i class="fas fa-power-off"></i>
                        {{ $promotion->isActive() ? trans('labels.pause') : trans('labels.active') }}</span></button>
                {!! Form::close() !!}
            </li>
        @endif
        {!! Form::open([
            'url' => route('admin.promotion.destroy', $promotion->id),
            'method' => 'DELETE',
            'class' => 'ajax-form',
        ]) !!}
        <button type="submit" class="dropdown-item ajax-confirm"><span
                class="badge badge-danger d-block text-danger"><i
                    class="fas fa-trash p-1"></i>{{ trans('labels.delete') }}</span></button>
        {!! Form::close() !!}
    </ul>
</div>
<script>
    $('.ajax-form').ajaxForm({
        success: (res) => {
            promotionProductTable.ajax.reload()
            flashSaleTable.ajax.reload()
            tata.success('{{ trans('toast.action_successful') }}', res.data.message)
        }
    })
</script>
