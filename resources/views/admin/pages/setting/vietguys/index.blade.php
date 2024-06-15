@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => 'Vietguys'])
    <div class="container-fluid">
        <div class="container-fluid">
            <x-admin.card header="Vietguys - Config">
                {!! Form::model($setting, [
                    'url' => route('admin.setting.vietguys.update'),
                    'method' => 'PUT'
                ]) !!}
                  <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label("data[refresh_token]", "Refresh token: ", ['class' => 'form-label']) !!}
                            {!! Form::text("data[refresh_token]", null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label("data[username]", "Username: ", ['class' => 'form-label']) !!}
                            {!! Form::text("data[username]", null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label("data[brand_name]", "Brand name: ", ['class' => 'form-label']) !!}
                            {!! Form::text("data[brand_name]", null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    {!! Form::submit(trans('labels.update'), ['class' => 'btn btn-primary submit-btn']) !!}
                </div>
                {!! Form::close() !!}
            </x-admin.card>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
@endpush
