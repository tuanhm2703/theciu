<div>
    <div class="voucher-info">
        <div class="voucher-tag">
            <div class="text-center">
                <svg width="40" height="42" viewBox="0 0 40 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24.3053 38.9535H5.35296V17.632H32.9914V26.1702" stroke="#A5A5A5" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M36.5462 11.3153H1.8V17.6331H36.5462V11.3153Z" stroke="#A5A5A5" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M21.1469 18.0276H17.1984V38.5591H21.1469V18.0276Z" stroke="#A5A5A5" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M19.3574 11.3306C19.3574 11.3306 19.0358 5.37864 22.4563 2.72712C26.424 -0.344876 31.56 5.25775 28.1434 8.93455C26.6323 10.5608 23.9338 11.7117 19.3574 11.3306Z"
                        stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M18.9878 11.3306C18.9878 11.3306 19.3094 5.37864 15.889 2.72712C11.9213 -0.344876 6.78528 5.25775 10.2019 8.93455C11.713 10.5608 14.4115 11.7117 18.9878 11.3306Z"
                        stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M25.9421 41.2107L35.379 27.3911H37.7284L28.2915 41.2107H25.9421ZM27.1464 34.8537C26.4752 34.8537 25.8829 34.7023 25.3696 34.3996C24.8563 34.0837 24.4483 33.6428 24.1456 33.0769C23.856 32.4978 23.7113 31.8199 23.7113 31.0434C23.7113 30.2669 23.856 29.5956 24.1456 29.0297C24.4483 28.4637 24.8563 28.0228 25.3696 27.7069C25.8829 27.3911 26.4752 27.2331 27.1464 27.2331C27.8177 27.2331 28.4099 27.3911 28.9232 27.7069C29.4365 28.0228 29.838 28.4637 30.1275 29.0297C30.4171 29.5956 30.5619 30.2669 30.5619 31.0434C30.5619 31.8199 30.4171 32.4978 30.1275 33.0769C29.838 33.6428 29.4365 34.0837 28.9232 34.3996C28.4099 34.7023 27.8177 34.8537 27.1464 34.8537ZM27.1464 33.2348C27.5808 33.2348 27.9295 33.0571 28.1928 32.7018C28.456 32.3332 28.5876 31.7805 28.5876 31.0434C28.5876 30.3064 28.456 29.7601 28.1928 29.4048C27.9295 29.0363 27.5808 28.852 27.1464 28.852C26.7253 28.852 26.3765 29.0363 26.1001 29.4048C25.8368 29.7601 25.7052 30.3064 25.7052 31.0434C25.7052 31.7673 25.8368 32.3135 26.1001 32.682C26.3765 33.0505 26.7253 33.2348 27.1464 33.2348ZM36.5241 41.3687C35.866 41.3687 35.2737 41.2173 34.7473 40.9146C34.2339 40.5987 33.8325 40.1578 33.543 39.5919C33.2534 39.0128 33.1086 38.3349 33.1086 37.5584C33.1086 36.7819 33.2534 36.1106 33.543 35.5447C33.8325 34.9787 34.2339 34.5378 34.7473 34.2219C35.2737 33.9061 35.866 33.7481 36.5241 33.7481C37.2085 33.7481 37.8073 33.9061 38.3206 34.2219C38.8339 34.5378 39.2354 34.9787 39.5249 35.5447C39.8145 36.1106 39.9592 36.7819 39.9592 37.5584C39.9592 38.3349 39.8145 39.0128 39.5249 39.5919C39.2354 40.1578 38.8339 40.5987 38.3206 40.9146C37.8073 41.2173 37.2085 41.3687 36.5241 41.3687ZM36.5241 39.7498C36.9584 39.7498 37.3072 39.5721 37.5704 39.2168C37.8336 38.8482 37.9653 38.2954 37.9653 37.5584C37.9653 36.8345 37.8336 36.2883 37.5704 35.9198C37.3072 35.5513 36.9584 35.367 36.5241 35.367C36.1029 35.367 35.7541 35.5513 35.4777 35.9198C35.2145 36.2751 35.0829 36.8213 35.0829 37.5584C35.0829 38.2954 35.2145 38.8482 35.4777 39.2168C35.7541 39.5721 36.1029 39.7498 36.5241 39.7498Z"
                        fill="#D3AD86" />
                </svg>
            </div>
            <h6 class="font-weight-bold my-3">Chúc mừng bạn!</h6>
            <h5 class="text-center voucher-discount-info mb-0">{{ $voucher->discount_label }}</h5>
        </div>
    </div>
    <div class="congrats-content pt-0">
        <p class="text-center mb-1 text-center text-dark">Đơn tối thiểu từ
            {{ thousandsCurrencyFormat($voucher->min_order_value) }}</p>
        <div class="text-center">
            <button @disabled($voucher->saved || $voucher->quantity == 0) wire:click="saveVoucher({{ $voucher->id }})"
                class="btn btn-primary font-weight-bold text-uppercase">
                <span wire:loading wire:target="saveVoucher" class="spinner-border spinner-border-sm mr-3"
                    role="status" aria-hidden="true"></span>
                <span wire:loading.remove wire:target="saveVoucher">
                    @if (auth('customer')->check())
                        @if ($voucher->saved)
                            {{ trans('labels.saved') }}
                        @elseif($voucher->quantity == 0)
                            {{ trans('labels.out_of_quantity') }}
                        @else
                            {{ trans('labels.save') }}
                        @endif
                    @else
                        {{ trans('labels.login_now') }}
                    @endif
                </span>
            </button>
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {})
    </script>
@endpush
