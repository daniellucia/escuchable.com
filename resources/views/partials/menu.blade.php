<div class="MainMenu">
    <p class="Title Sticky">escuchable</p>
    <ul class="Menu">
        <li><a href="{{ route('home') }}">Inicio</a></li>
        @guest
            <li><a href="{{ route('login') }}">Entrar</a></li>
            <li><a href="{{ route('register') }}">Registro</a></li>
        @else
            <li><span> {{ Auth::user()->name }}</span></li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">Salir</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest
        <li><a href="#">Descubrir</a></li>
    </ul>
</div>
