@push('css')

@endpush
@foreach ($popups as $item)
    <div class="popup-banner-item sticky-header" id="{{ $item->id }}-popup-banner">
        <img src="{{ $item->image->path_with_domain }}" alt="">
    </div>
@endforeach
@push('js')
    <script>
        const popups = @json(popups);
        popups.forEach(popup => {
            $.magnificPopup.open({
            items: {
                src: `${popup.id}-popup-banner`,
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
                    $('.popup-banner-item').hide();
                    $("body").css("overflow-x", "hidden");
                    $(".sticky-header.fixed").css("padding-right", "0");
                },
            },
        });
        });
    </script>
@endpush
