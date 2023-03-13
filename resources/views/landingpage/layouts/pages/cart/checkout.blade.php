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
        $('#createAddressModal').on('shown.bs.modal', (e) => {
            $('#createAddressModal form').trigger('reset')
        })
        window.addEventListener('addressUpdated', (e) => {
            tata.success(@json(trans('toast.action_successful')), e.detail.message)
            $('#return-address-list-btn').trigger('click')
        });
        const initChangeModal = () => {
            $('.submit-change-address-btn').on('click', (e) => {
                e.preventDefault()
                if ($('input[name=shipping-address]:checked').val()) {
                    Livewire.emit('cart:changeAddress', $('input[name=shipping-address]:checked').val())
                    $('.modal.show').modal('hide')
                }
            })
            $('.update-address-btn').on('click', (e) => {
                e.preventDefault()
                Livewire.emit('address:change', $(e.currentTarget).attr('data-address-id'))
                $(e.currentTarget).parents('.modal').modal('hide')
                $('#updateAddressModal').modal('show')
            })

            $('.delete-address-btn').on('click', (e) => {
                $(e.currentTarget).parent().submit()
            })
            $('.delete-address-form').ajaxForm({
                success: (res, statusText, xhr, $form) => {
                    tata.success(@json(trans('toast.action_successful')), res.data.message)
                    $($form).parents('.address-row').remove()
                }
            })
        }
    </script>
@endpush
