@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Mulish:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: "super-comic";
            src: url("{{ asset('assets/fonts/Pony.ttf') }}") format("truetype");
        }
        @font-face {
            font-family: "pfbeau-sans-pro-bbook";
            src: url("{{ asset('assets/fonts/PFBeauSansPro-Bbook.ttf') }}") format("truetype");
        }

        #spinner-wheel {
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 500px !important;
        }

        #wrapper {
            background: url("{{ asset('img/spinner-bg.jpg') }}") !important;
            background-size: cover !important;
            background-position: center !important;
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            flex-direction: column;
        }

        #wrapper .spinner-img {
            transition: all 6s cubic-bezier(0, 0.99, 0.44, 0.99);
            padding: 0 8%;
            display: flex;
            align-items: center;
        }

        #spinner-btn {
            width: 80px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            cursor: pointer;
        }

        #spinner-btn:hover {
            animation: circleScale 1s infinite;
        }

        .spinner-description {
            font-family: 'Montserrat', sans-serif;
            bottom: 10px;
            max-width: 80%;
            color: #2b3c68;
            font-size: 2.3rem;;
        }
        .spinner-description p {
            color: #ec4c6e;
        }
        @media (max-width: 768px) {
            #spinner-btn {
                width: 65px;
            }
            .spinner-description {
                font-size: 18px;
            }
        }

        @keyframes circleScale {
            0% {
                transform: translate(-50%, -50%) scale(1.05)
            }

            50% {
                transform: translate(-50%, -50%) scale(1)
            }

            100% {
                transform: translate(-50%, -50%) scale(1.05)
            }
        }

        .firework-container {
            height: 300px;
            position: absolute;
            width: 300px;
            top: 48%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .event-header-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
            justify-content: space-between;
        }
        .event-header-wrapper {
            padding: 0 2rem;
        }
        .event-header-wrapper #slogan-img {
            width: 100px !important;
        }
        .event-header-wrapper #event-logo {
            width: 57px !important;
        }
        .congrat-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: bold;
            color: #041c53 !important;
        }
        .congrat-text .gift-note{
            font-family: 'pfbeau-sans-pro-bbook';
        }
        .congrat-text .gift-note,.congrat-text #gift-name {
            color: #ef4b6e !important;
        }
    </style>
@endpush
<div class="voucher-popup container newsletter-popup-container" id="spinner-wheel">
    <div id="wrapper">
        <div class="event-header-wrapper pt-3">
            <img src="{{ asset('img/slogan-img.png') }}" id="slogan-img" alt="">
            <img src="{{ asset('img/event-logo.png') }}" id="event-logo" alt="">
        </div>
        @if ($showGift == false)
            <img src="{{ asset('img/spinner.png') }}" class="spinner-img mb-2" alt=""
                style="transform: rotate({{ $deg }}deg)">
            <img id="spinner-btn" src="{{ asset('img/spinner-btn.png') }}" alt="">
            <div class="spinner-description text-center pb-3">Xoay để nhận được quà ưng ý nhé!</div>
        @else
            <img width="50%" class="animate__animated animate__tada" src="{{ $gift['img'] }}" alt="">
            <div class="spinner-description text-center congrat-text">
                Chúc mừng bạn đã nhận được <br><span id="gift-name">"{{ $gift['name'] }}"</span>
                <p class="gift-note mt-3">Phần quà sẽ được gửi cùng đơn hàng của bạn, chụp lại khoảnh khắc này và khoe với bạn bè nhé!</p>
            </div>
        @endif
        {{-- <div class="firework-container"></div> --}}
    </div>
</div>
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/fireworks-js@2.x/dist/index.umd.js"></script>
    <script src="https://unpkg.com/fireworks-js@2.x/dist/index.umd.js"></script>

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
                        // const container = document.querySelector('.firework-container')
                        // const fireworks = new Fireworks.default(container)
                        // fireworks.start()
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
        var click = false;

        $(document).ready(function() {
            /*WHEEL SPIN FUNCTION*/
            $("#spinner-btn").click(async function() {
                if (click === false) {
                    await @this.getDeg()
                    setTimeout(() => {
                        @this.updateGift()
                    }, 6500);
                }
                // //add 1 every click
                // clicks++;

                // var newDegree = degree * clicks;
                // var extraDegree = Math.floor(Math.random() * (360 - 1 + 1)) + 1;
                // totalDegree = newDegree + extraDegree;

                // $("#wrapper .spinner-img").css({
                //         transform: "rotate(" + totalDegree + "deg)",
                //     });

            });
            @this.on('getDeg', function() {
                console.log('hello');
            })
        }); //DOCUMENT READY
    </script>
@endpush
