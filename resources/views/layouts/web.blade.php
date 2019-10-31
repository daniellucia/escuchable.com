<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/fonts/apercu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts/source-sans.css') }}" rel="stylesheet">
    <link href="{{ asset('css/web.css') }}" rel="stylesheet">
</head>
<body>



    <div class="web">

        @include('partials.categories')
        <div class="content">
            <header class="header"><p>escuchable</p></header>
            <div class="columns">
            @yield('content')
            </div>
        </div>

    </div>

</body>
</html>
