@extends('layouts.web')

@section('content')
<div class="Container">
    <div class="Title">{{ __('Registro') }}</div>
    <form method="POST" class="Form" action="{{ route('register') }}">
        @csrf

        <div class="Control">
            <label for="name">{{ __('Nombre') }}</label>
            <input id="name" type="text" class=" @error('name') IsInvalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
                <div class="ErrorInline" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        <div class="Control">
            <label for="email">{{ __('E-Mail') }}</label>
            <input id="email" type="email" class=" @error('email') IsInvalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

            @error('email')
                <div class="ErrorInline" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        <div class="Control">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" class=" @error('password') IsInvalid @enderror" name="password" required autocomplete="new-password">

            @error('password')
                <div class="ErrorInline" role="alert">
                    <strong>{{ $message }}</strong>
                </div>
            @enderror
        </div>

        <div class="Control">
            <label for="password-confirm">{{ __('Confirma Password') }}</label>
            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
        </div>

        <div class="Control">
            <button type="submit" class="Button">
                {{ __('Registro') }}
            </button>
        </div>
    </form>
</div>

@endsection
