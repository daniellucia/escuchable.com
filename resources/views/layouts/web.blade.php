<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.metatags')
    <link href="{{ asset('css/fonts/apercu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts/source-sans.css') }}" rel="stylesheet">
    <link href="{{ asset('css/web.css') }}?v=201911112242" rel="stylesheet">
</head>
<body>

    <div class="Web">
        @include('partials.menu')

       <div class="Content @if(Route::current()->getName() == 'home') ContentHome @endif">
            @if(Route::current()->getName() != 'home')
            <header class="Header">
                <div class="HeaderContent">
                    <form method="get" class="Search" action="{{ route('search.results') }}">
                        <input type="search" name="term" placeholder="Búsqueda..." autocomplete="off" @if (isset($term)) value="{{$term}}" @endif />
                    </form>

                </div>
            </header>
            @endif
            <div class="Columns">

                @if(session()->has('message'))
                    <div class="Alert Success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @yield('content')

            </div>
        </div>

    </div>

    @include('cookieConsent::index')

    {!! Analytics::render() !!}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

</body>
</html>
