<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>{{ isset($headTitle) ? env('APP_NAME') . " - $headTitle" : env('APP_NAME') }}</title>
<meta property="og:image" content="/img/logo-dark.png" />
<meta name="keywords" content="{{ $mKeywords }}">
<meta name="robots" content="index,follow">
<meta name="description"
    content="{{ isset($metaDescription) ? $metaDescription : 'Thời trang nữ THE CIU mang phong cách trẻ trung, năng động. Chuyên sản phẩm kết hợp đi học, đi chơi như áo thun, áo khoác, quần jean, đầm, chân váy.' }}">
<meta name="author" content="p-themes">
<meta name="locale" content="{{ App::getLocale() }}">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/landingpage/images/icons/apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('assets/landingpage/images/icons/site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('assets/landingpage/images/icons/safari-pinned-tab.svg') }}" color="#666666">
<link rel="icon" type="image/png" href="{{ asset('img/ciu-favicon.png') }}">
<meta name="apple-mobile-web-app-title" content="THE C.I.U">
<meta name="application-name" content="THE C.I.U">
<meta name="locale" content="{{ App::getLocale() }}">
<meta name="msapplication-TileColor" content="#cc9966">
<meta name="msapplication-config" content="{{ asset('assets/landingpage/images/icons/browserconfig.xml') }}">
<meta name="theme-color" content="#ffffff">
@isset($oTittle)
    <meta proterty="o:title" content="{{ $oTittle }}">
@endisset
@isset($oType)
    <meta proterty="o:type" content="{{ $oType }}">
@endisset
@isset($oImage)
    <meta proterty="o:image" content="{{ $oImage }}">
@endisset
@isset($oDescription)
    <meta proterty="o:description" content="{{ $oDescription }}">
@endisset
@isset($oUrl)
    <meta proterty="o:url" content="{{ $oUrl }}">
@endisset
@isset($oPrice)
    <meta proterty="o:price:amount" content="{{ $oPrice }}">
@endisset
@isset($oAvailability)
    <meta proterty="o:availability" content="{{ $oAvailability }}">
@endisset
<meta proterty="o:locale" content="{{ App::getLocale() }}">
<meta proterty="o:price:currency" content="VN">
