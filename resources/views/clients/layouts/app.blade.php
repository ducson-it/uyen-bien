<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Uyên Biển') - {{ setting('site_name', 'Uyên biển') }}</title>

    <title>Broccoli - Organic Food HTML Template</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <!-- Font Icons css -->
    <link rel="stylesheet" href="{{ asset('clients/css/font-icons.css') }}">
    <!-- plugins css -->
    <link rel="stylesheet" href="{{ asset('clients/css/plugins.css') }}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('clients/css/style.css') }}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('clients/css/responsive.css') }}">

    <!-- Styles -->
    {{-- <link href="{{ mix('css/app.css') }}" rel="stylesheet"> --}}

    @yield('styles')

</head>

<body>
    <div class="body-wrapper">

        @include('clients.layouts.header')
        @include('clients.partials.banner')

        <div class="container">

            @yield('content')

        </div>

        @include('clients.layouts.footer')
    </div>

    <!-- preloader area start -->
    <div class="preloader d-none" id="preloader">
        <div class="preloader-inner">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>
    <!-- preloader area end -->

    <!-- Scripts -->
    <script src="{{ asset('clients/js/plugins.js') }}"></script>
    <script src="{{ asset('clients/js/main.js') }}"></script>
    @yield('scripts')

</body>

</html>
