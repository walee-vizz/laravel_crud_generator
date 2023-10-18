<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('auth_title', 'Authentication - Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    @include('partials.backend.styles')
    <!-- Latest compiled and minified CSS -->
    {{-- @livewireStyles --}}


    @yield('styles')
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->

    @yield('auth-content')

    @include('partials.backend.auth_scripts')
    @yield('scripts')
</body>

</html>
