<div class="card">
    <div class="card-header">
        <h5 class="text-center text-uppercase">{{ trans('labels.create_rank') }}</h5>
    </div>
    <div class="card-body pt-0">
        {!! Form::open([
            'url' => route('admin.rank.store'),
            'method' => 'POST',
            'class' => 'rank-form',
        ]) !!}
        @include('admin.pages.rank.components.form')
        <div class="text-end mt-3">
            <button class="btn btn-primary submit-btn">{{ trans('labels.create') }}</button>
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
