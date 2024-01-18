@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => 'Cập nhật chương trình tặng sản phẩm khi mua 1 sản phẩm'])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => 'Cập nhật chương trình tặng sản phẩm khi mua 1 sản phẩm'])
    <div class="container-fluid">
        {!! Form::model($promotion, [
            'url' => route('admin.promotion.update', $promotion->id),
            'method' => 'PUT',
            'class' => 'promotion-form'
        ]) !!}
                @include('admin.pages.accom-product.form')
                {!! Form::close() !!}
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
@include('admin.pages.accom-product.assets._script')
@endpush
