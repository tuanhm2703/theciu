@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.product_list')])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.create_voucher')])
    <div class="container-fluid">
        {!! Form::open([
            'url' => route('admin.promotion.voucher.store'),
            'method' => 'POST',
            'class' => 'voucher-form',
        ]) !!}
        @include('admin.pages.promotion.voucher.form.form')
        <div class="row mt-3">
            <div class="offset-md-2 col-md-4 text-end">
                <button class="btn btn-primary submit-btn" type="submit">{{ trans('labels.create') }}</button>
            </div>
        </div>
        {!! Form::close() !!}
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        $('.voucher-form').ajaxForm({
            beforeSend: () => {
                $('.submit-btn').loading()
            },
            success: (res) => {
                toast.success('{{ trans('toast.action_successful') }}', res.data.message)
                setTimeout(() => {
                    window.location.href = `{{ route('admin.promotion.index') }}#voucher-list`
                }, 1500);
            }
        })
    </script>
@endpush
