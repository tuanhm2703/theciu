@extends('admin.layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom mt-0">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ user()->avatar_path }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ user()->name }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ user()->role->name }}
                        </p>
                    </div>
                </div>
                {{-- <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                                    <i class="ni ni-app"></i>
                                    <span class="ms-2">App</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                    <i class="ni ni-email-83"></i>
                                    <span class="ms-2">Messages</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center "
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <span class="ms-2">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">{{ trans('labels.edit_profile') }}</h6>
                            {{-- <button class="btn btn-primary btn-sm ms-auto">{{ trans('labels.settings') }}</button> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::model(user(), [
                            'url' => route('admin.profile.update'),
                            'method' => 'PUT',
                        ]) !!}
                        <p class="text-uppercase text-sm">{{ trans('labels.user_informations') }}</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('firstname', trans('labels.first_name'), ['class' => 'form-control-label']) !!}
                                    {!! Form::text('firstname', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('lastname', trans('labels.last_name'), ['class' => 'form-control-label']) !!}
                                    {!! Form::text('lastname', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('username', 'Username', ['class' => 'form-control-label']) !!}
                                    {!! Form::text('username', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email', trans('labels.email_address'), ['class' => 'form-control-label']) !!}
                                    {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <h6>{{ trans('labels.contact_informations') }}</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('address.details', trans('labels.address'), ['class' > 'form-control-label']) !!}
                                    {!! Form::text('address.details', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                           <livewire:address-select-component/>
                        </div>
                        <div class="text-end">
                            {!! Form::submit(trans('labels.update'), ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-profile h-100">
                    <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                       <h6 class="mt-3 text-start">Cập nhật mật khẩu</h6>
                    </div>
                    <div class="card-body pt-0">
                        <livewire:admin.update-password-component/>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
