@extends('landingpage.layouts.app', ['headTitle' => trans('labels.forgot_password')])
@push('css')
    <style>
        #forgot-password-form {
            width: 90%;
            max-width: 500px;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            margin: auto;
        }

        .main {
            height: 50vh;
        }
    </style>
@endpush
@section('content')
    <main class="main d-flex align-items-center justify-content-center">
        <livewire:client.forgot-password-component />
    </main><!-- End .main -->
@endsection

