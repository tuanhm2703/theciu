@extends('admin.layouts.app')
@section('content')
    @include('admin.layouts.navbars.auth.topnav', ['title' => trans('labels.address_list')])
    <div class="container-fluid">
        <x-admin.card header="{{ trans('labels.address_list') }}">
            <div class="d-flex justify-content-between">
                <i>Quản lý việc vận chuyển và địa chỉ giao hàng của bạn</i>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAddressModal">Thêm địa chỉ</button>
            </div>
            <livewire:admin.address.index></livewire:admin.address.index>
        </x-admin.card>

        <div class="modal fade address-modal" id="updateAddressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <livewire:admin.address.update></livewire:admin.address.update>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade address-modal" id="createAddressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <livewire:admin.address.create></livewire:admin.address.create>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layouts.footers.auth.footer')
    </div>
@endsection
@push('js')
    <script>
        $('.edit-address-btn').on('click', (e) => {
            const addressId = $(e.currentTarget).data('addressId')
            Livewire.emit('address:edit', addressId)
        })
        $('.address-modal').on('shown.bs.modal', (e) => {
            $('.address-form').trigger('reset')
            $('.address-submit-btn').loading(false)
            $('.address-form').ajaxForm({
                beforeSend: () => {
                    $('.address-submit-btn').loading()
                },
                success: (res) => {
                    tata.success(`{{ trans('toast.action_successful') }}`, res.data.message)
                    $('.modal.show').modal('hide')
                    Livewire.emit('admin:address:refresh')
                },
                error: () => {
                    $('.address-submit-btn').loading(false)
                }
            })
        })
    </script>
@endpush
