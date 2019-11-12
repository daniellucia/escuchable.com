@extends('layouts.web')

@section('content')

@section('breadcrumbs')
    {{ Breadcrumbs::render('home') }}
@endsection

<div class="Home">

    <form method="get" class="Search" action="{{ route('search.results') }}">
        <input type="search" name="term" placeholder="Búsqueda..." autocomplete="off" @if (isset($term)) value="{{$term}}" @endif />
    </form>

    @if (!empty($categories))
        <div class="Categories">
            <p class="Title">Categorías</p>
            <ul @if(isset($category)) class="categorySelected" @endif >
            @foreach ($categories as $item)
                <li id="{{ $item->slug }}" class=" @if(isset($category) && $item == $category) Selected @endif">
                    <a href="{{ route('category.view', $item) }}">
                        <span>
                            <em>{{ $item->shows()->count()}} shows</em>
                            {{ ucfirst($item->name) }}
                        </span>
                    </a>
                </li>
            @endforeach
            </ul>
        </div>
    @endif


    {{ Widget::recentEpisodes() }}
</div>

@endsection
