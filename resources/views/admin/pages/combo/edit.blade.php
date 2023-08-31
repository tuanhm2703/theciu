@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.edit_combo')])
@push('style')
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.edit_combo')])
    <div class="container-fluid">
        {!! Form::model($combo, [
            'url' => route('admin.combo.update', $combo->id),
            'method' => 'PUT',
            'class' => 'promotion-form'
        ]) !!}
                @include('admin.pages.combo.form')
                {!! Form::close() !!}
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
@include('admin.pages.combo.assets._script')
@endpush
