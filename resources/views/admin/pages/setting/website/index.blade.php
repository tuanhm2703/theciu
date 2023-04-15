@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => 'Website'])
    <div class="container-fluid">
        <div class="container-fluid">
            <x-admin.card header="Website">
                {!! Form::model($setting, [
                    'url' => route('admin.setting.website.update'),
                    'method' => 'PUT'
                ]) !!}
                <div class="form-group mb-3">
                    {!! Form::label('header_code', 'Header Code', ['class' => 'form-label']) !!}
                    {!! Form::textarea('header_code', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group mb-3">
                    {!! Form::label('footer_code', 'Footer Code', ['class' => 'form-label']) !!}
                    {!! Form::textarea('footer_code', null, ['class' => 'form-control summernote-code']) !!}
                </div>
                <div class="text-end">
                    {!! Form::submit(trans('labels.update'), ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </x-admin.card>

            @include('admin.layouts.footers.auth.footer')
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')

@endpush
