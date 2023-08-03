<div class="voucher-popup container newsletter-popup-container" id="spinner-wheel">
    <div id="wrapper">
        <div id="wheel">
            <div id="inner-wheel">
                <div class="sec">
                    <div class="item">
                        <div class="title">Note book</div>
                        <img width="90px" src="{{ asset('img/note-book.png') }}" alt="" />
                    </div>
                </div>
                <div class="sec">
                    <div class="item">
                        <div class="title">Bag</div>
                        <img width="90px" src="{{ asset('img/bag.png') }}" alt="" />
                    </div>
                </div>
                <div class="sec">
                    <div class="item">
                        <div class="title">Note book</div>
                        <img width="90px" src="{{ asset('img/note-book.png') }}" alt="" />
                    </div>
                </div>
                <div class="sec">
                    <div class="item">
                        <div class="title">Mirror</div>
                        <img width="90px" src="{{ asset('img/mirror.png') }}" alt="" />
                    </div>
                </div>
                <div class="sec">
                    <div class="item">
                        <div class="title">Note book</div>
                        <img width="90px" src="{{ asset('img/note-book.png') }}" alt="" />
                    </div>
                </div>
                <div class="sec">
                    <div class="item">
                        <div class="title">Bag</div>
                        <img width="90px" src="{{ asset('img/bag.png') }}" alt="" />
                    </div>
                </div>
                <div class="sec">
                    <div class="item">
                        <div class="title">Note book</div>
                        <img width="90px" src="{{ asset('img/note-book.png') }}" alt="" />
                    </div>
                </div>
                <div class="sec">
                    <div class="item">
                        <div class="title">Mirror</div>
                        <img width="90px" src="{{ asset('img/mirror.png') }}" alt="" />
                    </div>
                </div>
                <div class="sec">
                    <div class="item">
                        <div class="title">Note book</div>
                        <img width="90px" src="{{ asset('img/note-book.png') }}" alt="" />
                    </div>
                </div>
                <div class="sec">
                    <div class="item">
                        <div class="title">Bottle</div>
                        <img width="90px" src="{{ asset('img/water-bottle.png') }}" alt="" />
                    </div>
                </div>
            </div>

            <div id="spin">
                <div id="inner-spin"></div>
            </div>

            <div id="shine"></div>
        </div>
        <div id="txt"></div>
    </div>
</div>
@push('js')
    <script>
        $.magnificPopup.open({
            items: {
                src: "#spinner-wheel",
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
                        $('.voucher-popup').css('opacity', 1)
                    }, 500);
                },
                close: function() {
                    $("body").css("overflow-x", "hidden");
                    $(".sticky-header.fixed").css("padding-right", "0");
                },
            },
        });
        //set default degree (360*5)
        var degree = 1800;
        //number of clicks = 0
        var clicks = 0;

        $(document).ready(function() {
            /*WHEEL SPIN FUNCTION*/
            $("#spin").click(function() {
                //add 1 every click
                clicks++;

                /*multiply the degree by number of clicks
        generate random number between 1 - 360,
      then add to the new degree*/
                var newDegree = degree * clicks;
                var extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
                totalDegree = newDegree + extraDegree;

                /*let's make the spin btn to tilt every
          time the edge of the section hits
          the indicator*/
                $("#wheel .sec").each(function() {
                    var t = $(this);
                    var noY = 0;

                    var c = 0;
                    var n = 700;
                    var interval = setInterval(function() {
                        c++;
                        if (c === n) {
                            clearInterval(interval);
                        }

                        var aoY = t.offset().top;

                        /*23.7 is the minumum offset number that
                          each section can get, in a 30 angle degree.
                          So, if the offset reaches 23.7, then we know
                          that it has a 30 degree angle and therefore,
                          exactly aligned with the spin btn*/
                        if (aoY < 23.89) {
                            $("#spin").addClass("spin");
                            setTimeout(function() {
                                $("#spin").removeClass("spin");
                            }, 100);
                        }
                    }, 10);

                    $("#inner-wheel").css({
                        transform: "rotate(" + totalDegree + "deg)",
                    });

                    noY = t.offset().top;
                });
            });
        }); //DOCUMENT READY
    </script>
@endpush
