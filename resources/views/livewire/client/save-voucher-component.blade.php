<article class="voucher-container">
    <div class="voucher-title">
        <span class="text-center">
            <svg width="65" height="65" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.7544 34.1279H6.9608V16.36H29.9928V23.4752" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M32.9552 11.0961H4V16.3609H32.9552V11.0961Z" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20.1224 16.6896H16.832V33.7992H20.1224V16.6896Z" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M18.6312 11.1088C18.6312 11.1088 18.3632 6.14887 21.2136 3.93927C24.52 1.37927 28.8 6.04813 25.9528 9.11213C24.6936 10.4673 22.4448 11.4264 18.6312 11.1088Z" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M18.3232 11.1088C18.3232 11.1088 18.5912 6.14887 15.7408 3.93927C12.4344 1.37927 8.15439 6.04813 11.0016 9.11213C12.2608 10.4673 14.5096 11.4264 18.3232 11.1088Z" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M24.1185 36.009L31.9825 24.4926H33.9403L26.0762 36.009H24.1185ZM25.122 30.7114C24.5627 30.7114 24.0691 30.5853 23.6413 30.333C23.2136 30.0698 22.8736 29.7024 22.6213 29.2307C22.38 28.7481 22.2594 28.1833 22.2594 27.5362C22.2594 26.8891 22.38 26.3297 22.6213 25.8581C22.8736 25.3864 23.2136 25.019 23.6413 24.7558C24.0691 24.4926 24.5627 24.3609 25.122 24.3609C25.6814 24.3609 26.175 24.4926 26.6027 24.7558C27.0305 25.019 27.365 25.3864 27.6063 25.8581C27.8476 26.3297 27.9682 26.8891 27.9682 27.5362C27.9682 28.1833 27.8476 28.7481 27.6063 29.2307C27.365 29.7024 27.0305 30.0698 26.6027 30.333C26.175 30.5853 25.6814 30.7114 25.122 30.7114ZM25.122 29.3623C25.484 29.3623 25.7746 29.2143 25.994 28.9181C26.2133 28.611 26.323 28.1504 26.323 27.5362C26.323 26.922 26.2133 26.4668 25.994 26.1707C25.7746 25.8636 25.484 25.71 25.122 25.71C24.771 25.71 24.4804 25.8636 24.2501 26.1707C24.0307 26.4668 23.921 26.922 23.921 27.5362C23.921 28.1394 24.0307 28.5946 24.2501 28.9017C24.4804 29.2088 24.771 29.3623 25.122 29.3623ZM32.9367 36.1406C32.3883 36.1406 31.8948 36.0144 31.456 35.7622C31.0283 35.4989 30.6938 35.1315 30.4525 34.6599C30.2112 34.1773 30.0905 33.6124 30.0905 32.9653C30.0905 32.3182 30.2112 31.7589 30.4525 31.2872C30.6938 30.8156 31.0283 30.4482 31.456 30.1849C31.8948 29.9217 32.3883 29.7901 32.9367 29.7901C33.5071 29.7901 34.0061 29.9217 34.4339 30.1849C34.8616 30.4482 35.1961 30.8156 35.4374 31.2872C35.6787 31.7589 35.7994 32.3182 35.7994 32.9653C35.7994 33.6124 35.6787 34.1773 35.4374 34.6599C35.1961 35.1315 34.8616 35.4989 34.4339 35.7622C34.0061 36.0144 33.5071 36.1406 32.9367 36.1406ZM32.9367 34.7915C33.2987 34.7915 33.5893 34.6434 33.8087 34.3473C34.028 34.0402 34.1377 33.5795 34.1377 32.9653C34.1377 32.3621 34.028 31.9069 33.8087 31.5998C33.5893 31.2927 33.2987 31.1392 32.9367 31.1392C32.5857 31.1392 32.2951 31.2927 32.0648 31.5998C31.8454 31.896 31.7357 32.3511 31.7357 32.9653C31.7357 33.5795 31.8454 34.0402 32.0648 34.3473C32.2951 34.6434 32.5857 34.7915 32.9367 34.7915Z" fill="#D3AD86"/>
                </svg>
        </span>
    </div>
    <div class="voucher-splitter">
        <div class="voucher-top-circle"></div>
        <div class="voucher-bottom-circle"></div>
    </div>
    <div class="voucher-detail-info">
        <div class="voucher-detail-left">
            <h1 class="voucher-discount-value">
                Giảm {{ $voucher->discount_label }}
            </h1>
            <p>
                {{ $voucher->discount_description }}
            </p>
            <div>
                <div>
                    <span>HSD: {{ $voucher->begin->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
        <div class="voucher-detail-right">
            <button class="btn btn-primary mb-1" wire:click="saveVoucher"
                @disabled($voucher->saved || $voucher->quantity == 0)>
                <span wire:loading wire:target="saveVoucher" class="spinner-border spinner-border-sm mr-3"
                    role="status" aria-hidden="true"></span>
                <span wire:loading.remove
                    wire:target="saveVoucher">
                    @if ($voucher->saved)
                        {{ trans('labels.saved') }}
                    @elseif($voucher->quantity == 0)
                        {{ trans('labels.out_of_quantity') }}
                    @else
                    {{ trans('labels.save') }}
                    @endif
                </span>
            </button>
            <a href="#">Điều Kiện</a>
        </div>
    </div>
</article>
