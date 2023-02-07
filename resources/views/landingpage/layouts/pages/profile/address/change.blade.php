<div class="form-box p-5 position-relative" style="height: 600px; overflow: auto">
    <h5>Thay đổi địa chỉ</h5>
    <hr class="my-2">
    <div>
        @foreach ($addresses as $address)
            <div class="custom-control custom-radio py-2">
                <input type="radio" value="{{ $address->id }}" id="address-{{ $address->id }}"
                    @checked(empty($selected_address_id) ? $address->featured == 1 : $selected_address_id == $address->id) name="shipping-address" class="custom-control-input">
                <label for="address-{{ $address->id }}" class="custom-control-label d-inline-blox w-100">
                    <div style="line-height: 2rem">
                        <div class="text-md d-flex justify-content-between">
                            <div>
                                <h6 class="d-inline">{{ $address->fullname }}</h6> | {{ $address->phone }}
                            </div>
                            <div>
                                <a href="#" data-address-id="{{ $address->id }}" class="update-address-btn">Cập nhật</a>
                            </div>
                        </div>
                        <p>{{ $address->details }}</p>
                        <p>{{ $address->ward->name_with_type }}, {{ $address->ward->district->name_with_type }},
                            {{ $address->ward->district->province->name_with_type }}</p>
                        @if ($address->featured == 1)
                            <a class="btn btn-danger mt-1 py-2 text-white">Mặc định</a>
                        @endif
                    </div>
                </label>
            </div><!-- End .custom-control -->
            <hr class="my-2">
        @endforeach
    </div>
    <div class="text-right" style="background: white;
    position: sticky;
    bottom: -3rem;
    width: 100%;
    right: 0;
    padding: 1rem;">
        <button class="btn border ajax-modal-btn" data-toggle="modal" data-target="#createAddressModal"><i
            class="icon-plus"></i>Thêm Địa Chỉ
        Mới</button>
        <a href="#" class="btn btn-primary submit-change-address-btn">Xác nhận</a>
    </div>
</div>
<script>
    $('.submit-change-address-btn').on('click', (e) => {
        e.preventDefault()
        Livewire.emit('cart:changeAddress', $('input[name=shipping-address]:checked').val())
        $('.modal.show').modal('hide')
    })
    $('.update-address-btn').on('click', (e) => {
        e.preventDefault()
        Livewire.emit('address:change', $(e.currentTarget).data('addressId'))
        $('.modal.show').modal('hide')
        $('#updateAddressModal').modal('show')
    })
</script>
