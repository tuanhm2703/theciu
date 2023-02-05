<div>
    <div class="row d-flex align-items-stretch">
        <div class="col-lg-6">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h3 class="card-title">Địa chỉ cá nhân</h3><!-- End .card-title -->
                    @if ($address)
                        <p>
                            <span>{{ $address->full_address }}</span>
                            <a href="#"><br>{{ trans('labels.update') }} <i class="icon-edit"></i></a>
                        </p>
                    @else
                        <p>Bạn chưa có địa chỉ cá nhân, vui lòng cập nhật  <br>
                            <a href="#"><br>{{ trans('labels.update') }} <i class="icon-edit"></i></a></p>
                    @endif

                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->

        <div class="col-lg-6 h-100">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h3 class="card-title">Địa chỉ giao hàng</h3><!-- End .card-title -->
                    <div class="d-flex flex-column">
                        @foreach ($shipping_addresses as $address)
                            <p>{{ $address->full_address }} <a href="#">{{ trans('labels.update') }} <i
                                        class="icon-edit"></i></a></p>
                        @endforeach
                    </div>
                    {{-- <p>You have not set up this type of address yet.<br>
                        <a href="#">Edit <i class="icon-edit"></i></a>
                    </p> --}}
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->
</div>
