<div class="row py-5 px-3">
    <div class="col-5 position-relative">
        <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%)">
            <img src="https://cdn-icons-png.flaticon.com/512/3837/3837117.png" alt="">
        </span>
    </div>
    <div class="col-7">
        <h5 class="popupBox__title">Chúc mừng bạn!</h5>
        <h3 class="popupBox__titleTwo text-primary mb-1">{{ $voucher->voucher_type->name }}</h3>
        <p class="popupBox__description mb-1">
            - {{  $voucher->detail_info }} <br>
        </p>
        <p class="mb-0">
            <a href="{{ route('client.product.index') }}" class="popupBox__btn">Sử dụng ngay</a>
        </p>
    </div>
</div>
