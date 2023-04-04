<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MDCGLK4ZSC"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-MDCGLK4ZSC');
</script>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>{{ isset($headTitle) ? env('APP_NAME') . " - $headTitle" : env('APP_NAME') }}</title>
<meta name="robots" content="index,follow">

<meta name="author" content="p-themes">
<meta name="locale" content="{{ App::getLocale() }}">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/img/apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('assets/landingpage/images/icons/site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('/img/safari-pinned-tab.svg') }}" color="#666666">
<link rel="icon" type="image/png" href="/img/theciu-logo-16x16.jpg">
<meta name="apple-mobile-web-app-title" content="THE C.I.U">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
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
    <meta property="og:image" content="/img/theciu-meta.png" />
@endif
<meta proterty="o:locale" content="{{ App::getLocale() }}">
<meta proterty="o:price:currency" content="VN">
@if (isset($schemaMarkup))
    {!! $schemaMarkup!!}
@endif
