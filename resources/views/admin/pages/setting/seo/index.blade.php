@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => 'SEO'])
    <div class="container-fluid">
        <div class="container-fluid">
            <x-admin.card header="SEO - Meta Management">
                {!! Form::open([
                    'url' => route('admin.setting.seo.update'),
                    'method' => 'PUT'
                ]) !!}
                @foreach ($meta_tag->payload as $key => $value)
                    <div class="form-group">
                        {!! Form::label("meta[$key]", "Meta-$key", ['class' => 'form-label']) !!}
                        {!! Form::text("meta[$key]", $value, ['class' => 'form-control']) !!}
                    </div>
                @endforeach
                <div class="text-end mt-3">
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
