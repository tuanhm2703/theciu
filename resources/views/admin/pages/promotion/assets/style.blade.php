<style>
    .nav-item svg {
            width: 50px;
        }
    .voucher-info-container article {
        position: relative;
        width: 192px;
        height: 64px;
        float: left;
        border: 1px solid lightgrey;
        box-sizing: border-box;
        border-radius: 4px;
    }

    .voucher-info-container article div {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        line-height: 25px;
        transition: .5s ease;
    }

    .voucher-info-container article input {
        position: absolute;
        top: 0;
        left: 0;
        width: 140px;
        height: 100px;
        opacity: 0;
        cursor: pointer;
    }

    .voucher-info-container input[type=radio]:checked~.check-icon {
        background-color: #ee4d2d;
    }

    .voucher-info-container .upgrade-btn {
        display: block;
        margin: 30px auto;
        width: 200px;
        padding: 10px 20px;
        border: 2px solid #50bcf2;
        border-radius: 50px;
        color: #f5f5f5;
        font-size: 18px;
        font-weight: 600;
        text-decoration: none;
        transition: .3s ease;
    }

    .voucher-info-container .upgrade-btn:hover {
        background-color: #50bcf2;
    }

    .voucher-info-container .blue-color {
        color: #50bcf2;
    }

    .voucher-info-container .gray-color {
        color: #555;
    }

    .voucher-info-container .social i:before {
        width: 14px;
        height: 14px;
        position: fixed;
        color: #fff;
        background: #0077B5;
        padding: 10px;
        border-radius: 50%;
        top: 5px;
        right: 5px;
    }

    @keyframes slidein {
        from {
            margin-top: 100%;
            width: 300%;
        }

        to {
            margin: 0%;
            width: 100%;
        }
    }

    .voucher-info-container .check-icon {
        width: 28px;
        height: 28px;
        position: absolute;
        border-top-right-radius: 4px;
        top: 0;
        right: 0;
        background-color: grey;
    }

    .voucher-info-container .icon-ctn {
        position: absolute;
        border-top: 28px solid transparent;
        border-left: 28px solid #fff;
        height: 0;
        width: 0;
    }

    .voucher-info-container .the-ciu-icon {
        width: 16px;
        height: 16px;
        fill: #fff;
        position: absolute;
        top: -32px;
        right: 0;
    }

    .voucher-info-container .select2-container--default .select2-selection--single {
        border-radius: 0;
        border: 1px solid #d2d6da;
        border-right: 0;
        height: 100%;
    }

    .voucher-info-container input[name=value] {
        border-radius: 0;
    }

    .voucher-info-container .select2-container {
        height: 100%;
    }

    .voucher-info-container .selection {
        height: 100%;
    }

    .voucher-info-container .custom-control-label {
        line-height: 1rem;
    }
</style>
