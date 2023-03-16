@extends('landingpage.layouts.app')
@push('css')
    <style>
        .page-content-table thead tr th {
            font-size: 1.5em;
        }

        .page-content-table thead tr th {
            padding: 12px 0;
        }

        .page-content-table tbody tr td {
            font-size: 1.3em;
            padding: 2rem 5px;
            color: black;
            vertical-align: center;
        }

        .page-content-table tbody tr td.row-title {
            font-weight: bold;
            text-transform: uppercase;
            width: 20%;
            text-align: center;
        }

        .page-content-table ul {
            list-style-position: inside;
        }

        .page-content-table ul li::before {
            content: "\2022";
            color: black;
            font-weight: bold;
            display: inline-block;
            width: 1em;
        }
        .page-title {
            font-weight: bold;
            text-align: center;
            padding: 72px 0;
        }
    </style>
@endpush
@section('content')
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">{{ trans('labels.dashboard') }}</a></li>
                <li class="breadcrumb-item active"><a
                        href="#">{{ trans('labels.product_exchange_and_warranty_policy') }}</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        <div class="container">
            <h5 class="page-title">CHÍNH SÁCH BẢO HÀNH VÀ ĐỔI SẢN PHẨM</h5>
            <table class="w-100 table-bordered page-content-table">
                <thead>
                    <tr class="bg-dark text-white text-bold text-center text-uppercase">
                        <th>Quy định</th>
                        <th width="40%">Online</th>
                        <th>Offline</th>
                    </tr>
                </thead>
                <tbody>
                    <td class="row-title" rowspan="2">Điều kiện đổi hàng</td>
                    <td colspan="2">
                        <ul class="mb-0">
                            <li>Sản phẩm còn nguyên tem mác, chưa qua sử dụng và sửa chữa</li>
                            <li>Có hóa đơn mua hàng</li>
                        </ul>
                    </td>
                    </tr>
                    <tr>
                        <td>Thời gian đổi hàng kể từ khi nhận được sản phẩm: 5 ngày</td>
                        <td>Thời gian đổi hàng sau khi rời quầy thanh toán: 5 ngày</td>
                    </tr>
                    <tr>
                        <td class="row-title">Cách thức đổi</td>
                        <td>
                            Liên hệ bộ phận CSKH qua hotline 0775.665.912 và nhắn tin qua page để được hỗ trợ đổi hàng.
                            <br>
                            Hỗ trợ đổi hàng mua Online tại bất kì cửa hàng nào của shop
                        </td>
                        <td>
                            Quý khách hàng có thể đổi sản phẩm ở bất kì cửa hàng nào của shop.
                        </td>
                    </tr>
                    <tr>
                        <td class="row-title">GIÁ TRỊ HÀNG HOÁ ĐỔI</td>
                        <td colspan="2">
                            Chỉ áp dụng khi sản phẩm muốn đổi có giá lớn hơn hoặc bằng sản phẩm đã mua
                            <br>
                            Trường hợp sản phẩm đổi mới thấp hơn sản phẩm cũ, shop không hỗ trợ hoàn trả lại tiền chênh
                            lệch.
                        </td>
                    </tr>
                    <tr>
                        <td class="row-title">CHÍNH SÁCH ĐỔI</td>
                        <td colspan="2">
                            <ul class="mb-0">
                                <li>Mỗi đơn hàng chỉ hỗ trợ đối 1 lần
                                </li>
                                <li>
                                    Shop không có chính sách trả hàng
                                </li>
                                <li>Chính sách đổi hàng không áp dụng đối với hàng sale</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td class="row-title">PHÍ SHIP ĐỔI HÀNG</td>
                        <td>Miễn phí: hàng bị lỗi từ phía sản xuất, shop giao sai mẫu, sai kích thước
                            <br>
                            Khách hàng chịu phí ship 2 chiều: đổi theo yêu cầu của quý khách hàng
                        </td>
                        <td>Không mất phí khi ghé bất kì cửa hàng nào của shop để đổi hàng</td>
                    </tr>
                    <tr>
                        <td class="row-title" rowspan="2">LƯU Ý</td>
                        <td colspan="2">
                            Shop chỉ nhận trả hàng trong trường hợp sản phẩm bị lỗi nhưng khách không chọn được mẫu tương tự
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Quý khách vui lòng không gửi hàng khi chưa có sự xác nhận của bộ phận CSKH của shop. Nếu xảy ra
                            sự cố dẫn đến mất sản phẩm shop hoàn toàn không chịu trách nhiệm.
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
