@extends('layouts.web')

@section('content')

@section('breadcrumbs')
    {{ Breadcrumbs::render('home') }}
@endsection

<div class="Home">

    <form method="get" class="Search" action="{{ route('search.results') }}">
        <input type="search" name="term" placeholder="Búsqueda..." autocomplete="off" @if (isset($term)) value="{{$term}}" @endif />
    </form>

    @include('partials.categories')

    {{ Widget::recentEpisodes() }}
</div>

@endsection
