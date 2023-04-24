<div class="card">
    <div class="card-header">
        <h5 class="text-center text-uppercase">{{ trans('labels.update_rank') }}</h5>
    </div>
    <div class="card-body pt-0">
        {!! Form::model($rank, [
            'url' => route('admin.rank.update', $rank->id),
            'method' => 'PUT',
            'class' => 'rank-form',
        ]) !!}
        @include('admin.pages.rank.components.form')
        <div class="text-end mt-3">
            <button class="btn btn-primary submit-btn">{{ trans('labels.update') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script>
    $('form').ajaxForm({
            beforeSend: () => {
                $('.submit-btn').loading()
            },
            dataType: 'json',
            success: (res) => {
                toast.success('{{ trans('toast.action_successful') }}', res.data.message)
                $('.submit-btn').loading(false)
                table.ajax.reload()
                $('.modal').modal('hide')
            }
        })
</script>
