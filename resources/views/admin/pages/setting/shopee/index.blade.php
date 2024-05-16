@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => 'Shopee'])
    <div class="container-fluid">
        <div class="container-fluid">
            <x-admin.card header="Shopee - Config">
                {!! Form::model($setting, [
                    'url' => route('admin.setting.shopee.update'),
                    'method' => 'PUT'
                ]) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label("data[partnerId]", "Partner ID: ", ['class' => 'form-label']) !!}
                            {!! Form::text("data[partnerId]", null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label("data[partnerKey]", "Partner Key: ", ['class' => 'form-label']) !!}
                            {!! Form::text("data[partnerKey]", null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    {!! Form::submit(trans('labels.update'), ['class' => 'btn btn-primary']) !!}
                    <a class="btn btn-primary" href="{{ route('admin.setting.shopee.authorize') }}" target="_blank">Authorize</a>
                </div>
                {!! Form::close() !!}
            </x-admin.card>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
@endpush
