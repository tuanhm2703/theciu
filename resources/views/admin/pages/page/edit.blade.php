@extends('admin.layouts.app', ['class' => 'g-sidenav-show', 'headTitle' => trans('labels.page_list')])
@push('style')
    <style>
        .footer-widgets.footer.footer-2 * {
            max-width: 100%;
        }
    </style>
@endpush
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.page_list')])
    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0">
                <h6>
                    {{ trans('labels.edit_page') }}
                </h6>
            </div>
            <div class="card-body">
                {!! Form::model($page, [
                    'url' => route('admin.page.update', $page->id),
                    'method' => 'PUT',
                    'class' => 'page-form',
                ]) !!}
                @include('admin.pages.page.components.form')
                <div class="text-end mt-3">
                    {!! Form::submit(trans('labels.update'), ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
@endpush
