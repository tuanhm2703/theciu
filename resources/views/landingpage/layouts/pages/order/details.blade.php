@extends('landingpage.layouts.pages.profile.index')
@push('css')
    <style>
        #spinner-wheel {
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @font-face {
            font-family: "super-comic";
            src: url("{{ asset('assets/fonts/super-comic.ttf') }}") format("truetype");
        }

        a {
            color: #34495e;
        }

        #wrapper {
            position: relative;
        }

        #txt {
            color: #eaeaea;
        }

        #wheel {
            width: 500px;
            height: 500px;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
            border: 30px solid #2b3c68;
            box-shadow: rgba(0, 0, 0, 0.2) 0px 0px 10px,
                rgba(0, 0, 0, 0.05) 0px 3px 0px;
            transform: rotate(0deg);
            margin: auto;
            padding: 1rem;
        }

        #wheel:before {
            content: "";
            position: absolute;
            border: 6px solid #ef4b6f;
            width: 495px;
            height: 495px;
            border-radius: 50%;
            z-index: 1000;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #inner-wheel {
            width: 100%;
            height: 100%;
            transition: all 6s cubic-bezier(0, 0.99, 0.44, 0.99);
            transform: rotate(-7deg);
        }

        #wheel .sec {
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 373px 203px 0 75px;
            border-color: #19c transparent;
            transform-origin: 75px 373px;
            left: 139px;
            top: -162px;
            opacity: 1;
        }

        #wheel .sec img {
            max-width: 70px !important;
        }

        #wheel .sec:nth-child(1) {
            transform: rotate(36deg);
            border-color: #f596aa transparent;
            color: #3158a8 !important;
        }

        #wheel .sec:nth-child(2) {
            transform: rotate(72deg);
            border-color: #3158a8 transparent;
            color: #f596aa !important;
        }

        #wheel .sec:nth-child(3) {
            transform: rotate(108deg);
            border-color: #f596aa transparent;
            color: #3158a8 !important;
        }

        #wheel .sec:nth-child(4) {
            transform: rotate(144deg);
            border-color: #3158a8 transparent;
            color: #f596aa !important;
        }

        #wheel .sec:nth-child(5) {
            transform: rotate(180deg);
            border-color: #f596aa transparent;
            color: #3158a8 !important;
        }

        #wheel .sec:nth-child(6) {
            transform: rotate(216deg);
            border-color: #3158a8 transparent;
            color: #f596aa !important;
        }

        #wheel .sec:nth-child(7) {
            transform: rotate(252deg);
            border-color: #f596aa transparent;
            color: #3158a8 !important;
        }

        #wheel .sec:nth-child(8) {
            transform: rotate(288deg);
            border-color: #3158a8 transparent;
            color: #f596aa !important;
        }

        #wheel .sec:nth-child(9) {
            transform: rotate(324deg);
            border-color: #f596aa transparent;
            color: #3158a8 !important;
        }

        #wheel .sec:nth-child(10) {
            transform: rotate(360deg);
            border-color: #f7f16b transparent;
            color: #3158a8 !important;
        }

        #wheel .sec .item {
            margin-top: -200px;
            /* color: rgba(0, 0, 0, 0.2); */
            position: relative;
            z-index: 1000000;
            display: block;
            text-align: center;
            font-size: 18px;
            margin-left: -15px;
            text-shadow: rgba(255, 255, 255, 0.1) 0px -1px 0px,
                rgba(0, 0, 0, 0.2) 0px 1px 0px;
            transform: rotate(8deg);
        }

        #wheel .sec .item .title {
            width: 70px;
            margin-bottom: 1rem;
            font-family: "super-comic";
            font-size: 13px;
        }

        #spin {
            width: 68px;
            height: 68px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -34px 0 0 -34px;
            border-radius: 50%;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 3px 0px;
            z-index: 1000;
            background: #b14664;
            cursor: pointer;
            font-family: "Exo 2", sans-serif;
            user-select: none;
        }

        #spin:after {
            text-align: center;
            line-height: 68px;
            color: #fff;
            position: relative;
            z-index: 100000;
            width: 68px;
            height: 68px;
            display: block;
        }

        #spin:before {
            content: "";
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 20px 28px 20px;
            border-color: transparent transparent #ef4b6f transparent;
            top: -12px;
            left: 14px;
        }

        #inner-spin {
            width: 54px;
            height: 54px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin: -27px 0 0 -27px;
            border-radius: 50%;
            z-index: 999;
            /* box-shadow: rgba(255, 255, 255, 1) 0px -2px 0px inset,
                                                                            rgba(255, 255, 255, 1) 0px 2px 0px inset,
                                                                            rgba(0, 0, 0, 0.4) 0px 0px 5px; */
            background: radial-gradient(ellipse at center,
                    rgba(230, 73, 107, 1) 0%,
                    rgba(230, 73, 107, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#eaeaea', GradientType=1);
        }

        #spin:active #inner-spin {
            box-shadow: rgba(0, 0, 0, 0.4) 0px 0px 5px inset;
        }

        #spin:active:after {
            font-size: 15px;
        }

        #shine {
            width: 500px;
            height: 500px;
            position: absolute;
            top: 0;
            left: 0;
            background: radial-gradient(ellipse at center,
                    rgba(255, 255, 255, 1) 0%,
                    rgba(255, 255, 255, 0.99) 1%,
                    rgba(255, 255, 255, 0.91) 9%,
                    rgba(255, 255, 255, 0) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#00ffffff', GradientType=1);
            opacity: 0.1;
        }

        @keyframes hh {

            0%,
            100% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(7deg);
            }
        }

        .spin {
            animation: hh 0.1s;
        }

        @media (max-width: 768px) {
            #wheel {
                width: 300px;
                height: 300px;
                border: 15px solid #2b3c68;
            }

            #wheel .sec {
                left: 52px;
                top: -246px;
            }

            #wheel .sec .item {
                margin-top: -128px;
                margin-left: -13px;
            }

            #wheel .sec .item .title {
                width: 50px;
                margin-bottom: 0.2rem;
                font-size: 8px;
            }

            #wheel .sec img {
                max-width: 50px !important;
            }

            #spin {
                width: 34px;
                height: 34px;
                margin: -14px 0 0 -17px;
            }

            #spin:before {
                position: absolute;
                border-width: 0 7px 9px 7px;
                top: -2px;
                left: 10px;
            }

            #inner-spin {
                width: 27px;
                height: 27px;
                margin: -13px 0 0 -14px;
            }

            #spin:after {
                line-height: 68px;
                width: 34px;
                height: 34px;
            }
        }
    </style>
@endpush
@section('profile-content')
    <livewire:client.order-details :order="$order"></livewire:client.order-details>
    {{-- @if ($order->subtotal >= 500000) --}}
    <livewire:client.spinner-wheel />
    {{-- @endif --}}
@endsection
