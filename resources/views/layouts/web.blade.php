<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.metatags')
    <link href="{{ asset('css/fonts/apercu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts/source-sans.css') }}" rel="stylesheet">
    <link href="{{ asset('css/web.css') }}?v=20191106" rel="stylesheet">
</head>
<body>

    <div class="Web">

        @include('partials.categories')
        <div class="Content">
            <header class="Header">
                <form method="get" class="Search" action="{{ route('search.results') }}">
                    <input type="search" name="term" placeholder="Búsqueda..." autocomplete="off" @if (isset($term)) value="{{$term}}" @endif />
                </form>
                @include('partials.menu')
            </header>
            <div class="Columns">
            @yield('content')
            </div>
        </div>

    </div>
    {!! Analytics::render() !!}
</body>
</html>
