<div class="voucher-popup container newsletter-popup-container mfp-hide" id="newsletter-popup-form" wire:ignore>
    <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light" data-toggle="owl"
        data-owl-options='{
        "dots": true,
        "nav": true,
        "margin": 30,
        "autoplay": true,
        "autoplayTimeout": 3000,
        "items": 1,
        }' wire:ignore>
        @foreach ($vouchers as $voucher)
            <livewire:client.popup-voucher-component :voucher="$voucher"/>
        @endforeach

    </div>
    <div class="text-center text-white mt-1">
        <span wire:click="" id="close-no-reopen"><i class="fa fa-times"></i> Không hiện lại</span>
    </div>
</div>
<script>
    if (@json($vouchers->count() > 0 && !Session::has('prevent-reopen-voucher-popup'))) {
        setTimeout(function() {
            $.magnificPopup.open({
                items: {
                    src: "#newsletter-popup-form",
                },
                type: "inline",
                removalDelay: 350,
                callbacks: {
                    open: function() {
                        $("body").css("overflow-x", "visible");
                        $(".sticky-header.fixed").css(
                            "padding-right",
                            "1.7rem"
                        );
                    },
                    close: function() {
                        $("body").css("overflow-x", "hidden");
                        $(".sticky-header.fixed").css("padding-right", "0");
                    },
                },
            });
        }, 2000);
    }
    $('#close-no-reopen').on('click', (e) => {
        var mpInstance = $.magnificPopup.instance;
        if (mpInstance.isOpen) {
            mpInstance.close();
        }
        @this.setSessionNoReopen()
    })
</script>
