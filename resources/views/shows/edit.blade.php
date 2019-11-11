@extends('layouts.web')

@section('content')

<div class="Container">
    <div class="Title">{{ $show->name }}</div>

    <form method="POST" action="{{ route('show.edit', $show) }}" class="Form">
        @csrf

        @if(session()->has('message'))
            <div class="Alert Success">
                {{ session()->get('message') }}
            </div>
        @endif

        <div class="Control">
            <label for="feed">{{ __('Categoria') }}</label>
            <select name="category">
                @foreach ($categories as $item)
                <option value="{{ $item->id }}" @if($item->id == $show->categories_id) selected @endif>{{ ucfirst($item->name) }}</option>
                @endforeach
           </select>
        </div>

        <div class="Control">
            <button type="submit" class="Button">
                {{ __('Enviar') }}
            </button>
        </div>

        <div class="Control">
            {!! $show->description !!}
        </div>
    </form>
</div>

@endsection
