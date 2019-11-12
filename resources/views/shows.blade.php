@extends('layouts.web')

@section('content')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shows', $category) }}
@endsection

<div class="Shows">

    @yield('breadcrumbs')

    @if (!empty($shows))
        <div class="HeaderTitle">
            <h1 class="Sticky">{{$category->name}}</h1>
            <p class="Back">

                @can('edit category')
                <a class="Button" href="{{ route('categories.edit', $category)}}">Editar</a>
                @endcan

                <a class="Button" href="{{ route('home')}}">Volver</a>
            </p>
        </div>


        @include('partials.pagination', ['element' => $shows, 'text' => 'shows'])

        <ul class="List">
        @foreach ($shows as $item)
            @include('shows.detail')
        @endforeach
        </ul>

        @include('partials.pagination', ['element' => $shows, 'text' => 'shows'])
    @endif
</div>


@endsection
