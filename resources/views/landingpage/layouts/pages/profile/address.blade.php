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
                    toast.success(@json(trans('toast.action_successful')), res.data.message)
                    $($form).parents('.address-row').remove()
                }
            })
        }
        window.addEventListener('addressUpdated', (e) => {
            toast.success(@json(trans('toast.action_successful')), e.detail.message)
            $('#return-address-list-btn').trigger('click')
        });
    </script>
@endsection
