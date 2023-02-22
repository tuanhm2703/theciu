<div class="card">
    <div class="card-header">
        <h6>{{ trans('labels.create_role') }}</h6>
    </div>
    <div class="card-body pt-0">
        {!! Form::open([
            'url' => route('admin.role.store'),
            'method' => 'POST',
            'class' => 'role-form',
            'required'
        ]) !!}
        @include('admin.pages.module.components.form')
        <div class="text-end">
            <button type="submit" class="btn btn-primary submit-btn">{{ trans('labels.create') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script>
    $('.role-form').ajaxForm({
        beforeSend:() => {
            $('.role-form button[type=submit]').loading()
        },
        success: (res) => {
            tata.success(@json(trans('toast.action_successful')), res.data.message)
            $('.modal.show').modal('hide')
            table.ajax.reload()
        },
        error: (err) => {
            tata.error(@json(trans('toast.action_failed')), err.responseJSON.message);
            $('.role-form button[type=submit]').loading(false)
        }
    })
</script>
