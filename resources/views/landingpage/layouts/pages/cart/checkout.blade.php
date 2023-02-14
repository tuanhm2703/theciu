@extends('landingpage.layouts.app')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('/assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">{{ trans('labels.cart') }}<span>{{ trans('labels.checkout') }}</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.cart') }}</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="cart">
                <div class="container">
                    <livewire:cart-component></livewire:cart-component>
                    @include('landingpage.layouts.pages.profile.address.update')
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->
        @include('landingpage.layouts.pages.profile.address.create')
    </main><!-- End .main -->
@endsection
@push('js')
    <script>
        var createAddressFormValidator = $('#create-address-form').initValidator()
        $('#create-address-form').ajaxForm({
            beforeSend: () => {

            },
            success: (res) => {
                $('#return-address-list-btn').trigger('click')
            },
            error: (err) => {
                if (err.status === 422) {
                    const errors = err.responseJSON.errors;
                    Object.keys(err.responseJSON.errors).forEach((key) => {
                        createAddressFormValidator.errorTrigger(
                            $(`#create-address-form .form-control[name=${key}]`),
                            errors[key][0]
                        );
                    });
                }
            }
        })
        $('#updateAddressModal').on('shown.bs.modal', (e) => {
            $('#update-address-form').ajaxForm({
                beforeSend: () => {
                    $('.address-update-btn').loading()
                },
                success: () => {
                    $('#return-address-list-btn').trigger('click')
                },
                error: () => {
                    $('.address-update-btn').loading(false)
                }
            })
        })
    </script>
@endpush
