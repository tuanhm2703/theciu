@push('css')
    <style>
        .voucher-popup {
            width: 100% !important;
            /* max-width: 500px !important; */
        }

        .shaking-btn {
            border: none;
            background: url("{{ asset('img/bg-shake-btn.png') }}");
            background-position: center;
            background-size: contain;
            color: rgb(224, 186, 126);
            font-size: 1.3em;
            padding: 1rem;
        }
        @media only screen and (max-width: 768px) {
            #shake-img {
                max-width: 100% !important;
            }
        }
    </style>
@endpush
<div class="voucher-popup container newsletter-popup-container text-center d-none" wire:ignore.self id="lucky-shake">
    <img wire:ignore id="shake-img" src="{{ asset('img/shake-img.png') }}"
        alt="">
    <div class="text-center">
        <button wire:ignore type="button" class="shaking-btn" id="shaking-btn">CHẠM ĐỂ GIEO QUẺ</button>
        <button wire:ignore wire:click.prevent="confirmOrder" type="button" style="display: none" id="order-continue-btn" class="shaking-btn">TIẾP TỤC ĐƠN HÀNG</button>
    </div>
</div>
@push('js')
    <script>
        $('#shaking-btn').on('click', async function() {
            await @this.shake();
            $(this).hide();
            $('#shake-img').attr('src', `{{ asset('img/shake-motion.gif') }}`)
            setTimeout(() => {
                $('#shake-img').attr('src', @this.discount_image);
                $('#shake-img').css('max-width', '600px')
                $('#order-continue-btn').show()
            }, 2600)
        })
    </script>
@endpush
