@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.product_list')])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.edit_voucher')])
    <div class="container-fluid">
        {!! Form::model($voucher, [
            'url' => route('admin.promotion.voucher.update', $voucher->id),
            'method' => 'PUT',
            'class' => 'voucher-form',
        ]) !!}
        @include('admin.pages.promotion.voucher.form.form')
        <div class="row mt-3">
            <div class="offset-md-2 col-md-4 text-end">
                <button class="btn btn-primary submit-btn" type="submit">{{ trans('labels.update') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        var form = $('form').initValidator()
        $('.voucher-form').ajaxForm({
            beforeSend: () => {
                $('.submit-btn').loading()
            },
            success: (res) => {
                toast.success('{{ trans('toast.action_successful') }}', res.data.message)
                setTimeout(() => {
                    window.location.href = `{{ route('admin.promotion.index') }}#voucher-list`
                }, 1500);
            },
            error: (err) => {
                if (err.status === 422) {
                    const errors = err.responseJSON.errors;
                    Object.keys(err.responseJSON.errors).forEach((key) => {
                        form.errorTrigger(
                            $(`form .form-control[name=${key}]`),
                            errors[key][0]
                        );
                    });
                }
                $('.submit-btn').loading(false)
            }
        })
    </script>
@endpush
