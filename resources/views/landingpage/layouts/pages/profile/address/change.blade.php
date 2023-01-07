<div class="form-box p-5 position-relative" style="height: 600px; overflow: scroll">
    <h5>Thay đổi địa chỉ</h5>
    <hr class="my-2">
    {!! Form::open([]) !!}
    <div>
        @foreach ($addresses as $address)
            <div class="custom-control custom-radio py-2">
                <input type="radio" id="address-1" name="shipping-address" class="custom-control-input">
                <label for="address-1" class="custom-control-label d-inline-blox w-100">
                    <div style="line-height: 2rem">
                        <div class="text-md d-flex justify-content-between">
                            <div>
                                <h6 class="d-inline">Hoàng Mạnh Tuấn</h6> | (+84) 968297709
                            </div>
                            <div>
                                <a href="#">Cập nhật</a>
                            </div>
                        </div>
                        <p>36 Tây Thạnh</p>
                        <p>Phường Tây Thạnh, Quận Tân Phú, TP. Hồ Chí Minh</p>
                        <a class="btn btn-danger mt-1 py-2 text-white">Mặc định</a>
                    </div>
                </label>
            </div><!-- End .custom-control -->
            <hr class="my-2">
        @endforeach
    </div>
    <div class="text-left mt-2">
        <a class="btn border ajax-modal-btn" data-toggle="modal" data-target="#createAddressModal"><i class="icon-plus"></i>Thêm Địa Chỉ
            Mới</a>
    </div>
    <div class="text-right" style="position: absolute; bottom: 0;
    width: 100%;
    right: 0;
    padding: 1rem;">
        <hr class="my-3">
        {!! Form::submit('Xác nhận', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
