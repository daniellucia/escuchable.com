<ul class="Menu">
    <li><a href="{{ route('home') }}">Inicio</a></li>
    @guest
        <li><a href="{{ route('login') }}">Entrar</a></li>
        <li><a href="{{ route('register') }}">Registro</a></li>
    @else
        <li><strong> {{ Auth::user()->name }}</strong></li>
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
