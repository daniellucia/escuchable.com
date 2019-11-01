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

    <div class="Web">

        @include('partials.categories')
        <div class="Content">
            <header class="Header">
                <form method="get" class="Search" action="{{ route('search.results') }}">
                    <input type="search" name="term" placeholder="Búsqueda..." autocomplete="off" @if (isset($term)) value="{{$term}}" @endif />
                </form>
                <ul class="Menu">
                    <li><a href="#">Entrar</a></li>
                    <li><a href="#">Descubrir</a></li>
                </ul>
            </header>
            <div class="Columns">
            @yield('content')
            </div>
        </div>

    </div>

</body>
</html>
