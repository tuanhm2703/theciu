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
        #lucky-result-img {
            opacity: 0;
            transition: all 0.1s ease-in;
            width: 0%;
        }
        #shake-img {
            opacity: 1;
            transition: all 0.1s ease-in;
            width: 100%;
            max-width: 1500px;
        }
        @media only screen and (max-width: 768px) {
            #shake-img {
                max-width: 100% !important;
            }
            .shaking-btn {
                font-size: 1rem;
            }
        }
    </style>
@endpush
<div class="voucher-popup container newsletter-popup-container text-center d-none" wire:ignore.self id="lucky-shake">
    <img wire:ignore id="shake-img" src="{{ asset('img/shake-img.png') }}"
        alt="">
    <img wire:ignore id="lucky-result-img" src="" alt="">
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
            $('#shake-img').on('load', function() {
                console.log('loaded');
                setTimeout(() => {
                $('#shake-img').css('opacity', '0');
                setTimeout(() => {
                    $('#shake-img').css('width', '0');
                    $('#lucky-result-img').attr('src', @this.discount_image);
                    $('#lucky-result-img').css('width', '80%');
                    $('#lucky-result-img').css('opacity', '1');
                    $('#order-continue-btn').show()
                    $('.shaking-btn').css('padding', '1.1rem')
                }, 100)
            }, 2600)
            })

        })
    </script>
@endpush
