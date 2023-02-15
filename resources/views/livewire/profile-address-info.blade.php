<div>
    <div class="row d-flex align-items-stretch">
        <div class="col-lg-6">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h3 class="card-title">Địa chỉ cá nhân</h3><!-- End .card-title -->
                    @if ($address)
                        <p>
                            <span>{{ $address->full_address }}</span>
                            <a wire:click="openUpdateAddress({{ $address->id }})" data-toggle="modal"
                                data-target="#updateAddressModal" href="#"><br>{{ trans('labels.update_address') }}
                                <i class="icon-edit"></i></a>
                            {{-- <a wire:click="openUpdateAddress({{ $address->id }})" data-toggle="modal"
                                data-target="#updateAddressModel">
                                <br>
                                {{ trans('labels.update_address') }} <i class="icon-edit"></i>
                            </a> --}}
                        </p>
                    @else
                        <p>Bạn chưa có địa chỉ cá nhân, vui lòng cập nhật <br>
                            <a wire:click="updateAddressType('{{ App\Enums\AddressType::PRIMARY }}')" data-toggle="modal"
                                data-target="#createAddressModal"
                                href="#"><br>{{ trans('labels.create_address') }} <i class="icon-edit"></i></a>
                        </p>
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
                            <p>{{ $address->full_address }}
                                <a wire:click="openUpdateAddress({{ $address->id }})" data-toggle="modal"
                                    data-target="#updateAddressModal"
                                    href="#"><br>{{ trans('labels.update_address') }}
                                    <i class="icon-edit"></i></a>
                            </p>
                        @endforeach
                        @if ($shipping_addresses->count() < 10)
                        @endif
                    </div>
                    <p><a wire:click="updateAddressType('{{ App\Enums\AddressType::SHIPPING }}')" data-toggle="modal"
                        data-target="#createAddressModal"
                        href="#"><br>{{ trans('labels.create_address') }} <i class="icon-edit"></i></a></p>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->
    @include('landingpage.layouts.pages.profile.address.create')
    @include('landingpage.layouts.pages.profile.address.update')
</div>
