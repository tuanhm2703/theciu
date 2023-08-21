@push('css')
    <style>
        .popup-banner-item {
            opacity: 0;
            max-width: 50% !important;
            text-align: center;
        }
    </style>
@endpush
<div wire:init="loadPopups">
    @if ($readyToLoad)
        @foreach ($popups as $item)
            <div class="popup-banner-item sticky-header container" id="{{ $item->id }}-popup-banner">
                <img src="{{ $item->image->path_with_domain }}" alt="">
            </div>
        @endforeach
    @endif
</div>
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            @this.on('initPlugin', function(e) {
                const popups = e.popups;
                popups.forEach(popup => {
                    $.magnificPopup.open({
                        items: {
                            src: `#${popup.id}-popup-banner`,
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
                                setTimeout(() => {
                                    $('.popup-banner-item').css('opacity', 1)
                                }, 500);
                            },
                            close: function() {
                                $("body").css("overflow-x", "hidden");
                                $(".sticky-header.fixed").css("padding-right", "0");
                            },
                        },
                    });
                });
            })
        })
    </script>
@endpush
