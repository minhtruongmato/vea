<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/plugins/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('public/plugins/fa/css/all.min.css') }}">

    <!-- Zayeki CSS -->
    <link rel="stylesheet" href="{{ asset('public/plugins/zyk/css/zayeki.css') }}">

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('public/dist/css/style.css') }}">

    @yield('css')

    <title>@yield('page_title')</title>
</head>

<body class="overflow-y">
    @include('layouts.header')

    @yield('view')

    @include('layouts.footer')

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('public/plugins/jquery/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Common functions -->
    <script src="{{ asset('public/plugins/zyk/js/common.js') }}"></script>

    <!-- Zayeki Script -->
    <script src="{{ asset('public/plugins/zyk/js/zayeki.js') }}"></script>

    @yield('js')
</body>

</html>
