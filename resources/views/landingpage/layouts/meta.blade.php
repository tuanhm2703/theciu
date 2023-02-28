<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>{{ isset($headTitle) ? env('APP_NAME') . " - $headTitle" : env('APP_NAME') }}</title>
<meta name="robots" content="index,follow">

<meta name="author" content="p-themes">
<meta name="locale" content="{{ App::getLocale() }}">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/landingpage/images/icons/apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('assets/landingpage/images/icons/site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('assets/landingpage/images/icons/safari-pinned-tab.svg') }}" color="#666666">
<meta property="og:image" content="/img/logo-dark.png" />
<meta name="apple-mobile-web-app-title" content="THE C.I.U">
<meta name="application-name" content="THE C.I.U">
<meta name="locale" content="{{ App::getLocale() }}">
<meta name="msapplication-TileColor" content="#cc9966">
<meta name="msapplication-config" content="{{ asset('assets/landingpage/images/icons/browserconfig.xml') }}">
<meta name="theme-color" content="#ffffff">
@if (isset($metaTags))
    {!! $metaTags !!}
@else
    <meta name="description"
        content="Thời trang nữ THE CIU mang phong cách trẻ trung, năng động. Chuyên sản phẩm kết hợp đi học, đi chơi như áo thun, áo khoác, quần jean, đầm, chân váy.">
    <meta property="og:image" content="/img/logo-dark.png" />
@endif
<meta proterty="o:locale" content="{{ App::getLocale() }}">
<meta proterty="o:price:currency" content="VN">
