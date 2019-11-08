@extends('layouts.web')

@section('content')

<div class="Container">
    <div class="Title">{{ __('Enviar feed') }}</div>

    <form method="POST" action="{{ route('show.store') }}" class="Form">
        @csrf

        @if(session()->has('message'))
            <div class="Alert Success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="Control">
            <label for="feed">{{ __('Url feed') }}</label>
            <input id="feed" type="url" class=" @if($errors->any()) IsInvalid @endif" name="feed" value="{{ old('feed') }}" required autocomplete="email" autofocus>
        </div>
        @if($errors->any())
            <div class="ErrorInline" role="alert">
                <strong>{{$errors->first()}}</strong>
            </div>
        @endif

        <div class="Control">
            <button type="submit" class="Button">
                {{ __('Enviar') }}
            </button>
        </div>
    </form>
</div>

@endsection
