<div class="MainMenu">
    <p class="Title Sticky">escuchable</p>
    <ul class="Menu">
        <li><a href="{{ route('home') }}">Inicio</a></li>
        <li><a href="#">Descubrir</a></li>

        @can('show.create')
        <li><a href="{{ route('show.create') }}">Añadir show</a></li>
        @endcan

        @guest
            <li><a href="{{ route('login') }}">Entrar</a></li>
            <li><a href="{{ route('register') }}">Registro</a></li>
        @else
            <li class="Divider"><span> {{ Auth::user()->name }}</span></li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">Salir</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest

    </ul>
</div>
