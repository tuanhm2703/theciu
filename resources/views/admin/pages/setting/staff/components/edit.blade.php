<div class="card">
    <div class="card-header">
        <h6>{{ trans('labels.edit_staff') }}</h6>
    </div>
    <div class="card-body py-0">
        {!! Form::model($staff, [
            'url' => route('admin.setting.staff.update', ['staff' => $staff->id]),
            'method' => 'PUT',
            'class' => 'staff-form',
        ]) !!}
        @include('admin.pages.setting.staff.components.form')
        <div class="text-end">
            {!! Form::submit(trans('labels.edit_staff'), ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>
    (() => {
        var staffForm = $('.staff-form').initValidator()
        $('.staff-form').ajaxForm({
            beforeSend: () => {
                $('input[type=submit]').loading()
            },
            success: (res) => {
                $('.modal.show').modal('hide')
                toast.success(@json(trans('toast.action_successful')), res.data.message)
                table.ajax.reload()
            },
            error: (err) => {
                $('input[type=submit]').loading(false)
                if (err.status === 422) {
                    const errors = err.responseJSON.errors;
                    Object.keys(err.responseJSON.errors).forEach((key) => {
                        staffForm.errorTrigger(
                            $(`.staff-form .form-control[name=${key}]`),
                            errors[key][0]
                        );
                    });
                } else {
                    toast.success(@json(trans('toast.action_failed')), err.responesJSON.message)
                }
            }
        })
    })()
</script>
