@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => 'Tạo chương trình tặng sản phẩm khi mua đơn hàng tối thiểu'])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.create_combo')])
    <div class="container-fluid">
        {!! Form::open([
            'url' => route('admin.promotion.store'),
            'method' => 'POST',
            'class' => 'promotion-form'
        ]) !!}
                @include('admin.pages.accom-gift.form')
                {!! Form::close() !!}
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
@include('admin.pages.accom-gift.assets._script')
@endpush
