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
    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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

        <div class="container">

            @yield('content')

        </div>

        @include('clients.layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('clients/js/plugins.js') }}"></script>
    <script src="{{ asset('clients/js/main.js') }}"></script>
    @yield('scripts')

</body>

</html>
