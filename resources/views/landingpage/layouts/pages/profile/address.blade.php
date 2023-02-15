@extends('landingpage.layouts.pages.profile.index')
@section('profile-content')
    <livewire:profile-address-info></livewire:profile-address-info>
@endsection
@section('js')
    <script>
        var createAddressFormValidator = $('#create-address-form').initValidator()
        $('#create-address-form').ajaxForm({
            beforeSend: () => {

            },
            success: (res) => {
                Livewire.emitTo('profile-address-info', 'refresh')
                $('.modal.show').modal('hide')
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
                    Livewire.emitTo('profile-address-info', 'refresh')
                    $('.modal.show').modal('hide')
                },
                error: () => {
                    $('.address-update-btn').loading(false)
                }
            })
        })
    </script>
@endsection
