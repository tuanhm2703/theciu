@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.address_list')])
    <div class="container-fluid">
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')

@endpush
