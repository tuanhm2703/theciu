@extends('admin.layouts.app', ['class' => 'g-sidenav-show bg-gray-100', 'headTitle' => trans('labels.branch_list')])
@push('style')
    <style>
        #google-map-wrapper {
            height: 300px;
        }

        #pac-input {
            left: 1.4% !important;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.create_branch')])
    <div class="container-fluid">
        <div>
            {!! Form::model($branch, [
                'url' => route('admin.branch.update', $branch->id),
                'method' => 'PUT',
            ]) !!}
            @include('admin.pages.branch.components.form')
            <div class="text-end mt-3">
                <button  type="submit" class="btn btn-primary submit-btn">{{ __('labels.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
@include('admin.pages.branch.assets.script')
@endpush
