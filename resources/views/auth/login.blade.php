@extends('layouts.web')

@section('content')

<div class="Container">
    <div class="Title">{{ __('Login') }}</div>
    <form method="POST" action="{{ route('login') }}" class="Form">
        @csrf

        <div class="Control">
            <label for="email">{{ __('E-Mail') }}</label>
            <input id="email" type="email" class=" @error('email') IsInvalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        </div>
        @error('email')
            <div class="ErrorInline" role="alert">
                <strong>{{ $message }}</strong>
            </div>
        @enderror

        <div class="Control">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" class=" @error('password') IsInvalid @enderror" name="password" required autocomplete="current-password">
        </div>
        @error('password')
            <div class="ErrorInline" role="alert">
                <strong>{{ $message }}</strong>
            </div>
        @enderror

        <div class="Control">
            <label for="remember">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                {{ __('Recuérdame') }}
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Recordar mi clave') }}
                </a>
            @endif
        </div>

        <div class="Control">
            <button type="submit" class="Button">
                {{ __('Entrar') }}
            </button>
             <a class="Button Link" href="{{ route('register') }}">
                {{ __('Soy nuevo') }}
            </a>
        </div>
    </form>
</div>

@endsection
