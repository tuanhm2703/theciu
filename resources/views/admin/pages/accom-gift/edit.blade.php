@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => 'Cập nhật chương trình tặng sản phẩm khi mua đơn hàng tối thiểu'])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => 'Cập nhật chương trình tặng sản phẩm khi mua đơn hàng tối thiểu'])
    <div class="container-fluid">
        {!! Form::model($promotion, [
            'url' => route('admin.promotion.update', $promotion->id),
            'method' => 'PUT',
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
