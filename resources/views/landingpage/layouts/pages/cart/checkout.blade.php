@extends('landingpage.layouts.app')
@push('css')
    <style>
        .table td {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
    </style>
@endpush
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
                    <livewire:cart-component />
                    @if (now()->between('2024-02-13', '2024-02-25'))
                        <livewire:client.lucky-shake wire:key="lucky-shake" />
                    @endif
                    @include('landingpage.layouts.pages.profile.address.update')
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->
        @include('landingpage.layouts.pages.profile.address.create')
        <x-client.login-or-continue-component />
    </main><!-- End .main -->
@endsection
@push('js')
    <script>
        $('#createAddressModal').on('shown.bs.modal', (e) => {
            $('#createAddressModal form').trigger('reset')
        })
        window.addEventListener('addressUpdated', (e) => {
            toast.success(@json(trans('toast.action_successful')), e.detail.message)
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
            $('.update-address-btn').on('click', async (e) => {
                e.preventDefault()
                $(e.currentTarget).parents('.modal').modal('hide')
                await Livewire.emit('address:change', $(e.currentTarget).attr('data-address-id'))
                $('#updateAddressModal').modal('show')
            })

            $('.delete-address-btn').on('click', (e) => {
                $(e.currentTarget).parent().submit()
            })
            $('.delete-address-form').ajaxForm({
                success: (res, statusText, xhr, $form) => {
                    toast.success(@json(trans('toast.action_successful')), res.data.message)
                    $($form).parents('.address-row').remove()
                }
            })
        }
    </script>
    @if (!customer())
        <script>
            $('#login-or-continue-modal').modal('show')
        </script>
    @endif
@endpush
