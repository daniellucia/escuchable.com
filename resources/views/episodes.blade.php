@extends('layouts.web')

@section('content')

@section('breadcrumbs')
    {{ Breadcrumbs::render('episodes', $show) }}
@endsection

<div class="Episodes">

    @yield('breadcrumbs')

    @if (!empty($episodes))

        <div class="ShowDescription Sticky">
            <div class="HeaderTitle">
                <h1>{{$show->name}}</h1>
                <p class="Back">

                    @can('show.edit')
                    <a class="Button" href="{{ route('show.edit', $show)}}">Editar</a>
                    @endcan

                    <a class="Button" href="{{ route('category.view', [$category])}}">Volver</a>
                </p>
            </div>
            <div class="Description">
                {!! $show->description !!}
            </div>
        </div>

        @include('partials.pagination', ['element' => $episodes, 'text' => 'episodios'])

        @if ($episodes->total() > 0)
            <p class="Title">Episodios</p>
            <ul class="episodesList">
            @foreach ($episodes as $item)
                @include('episodes.detail')
            @endforeach
            </ul>
        @endif

        @include('partials.pagination', ['element' => $episodes, 'text' => 'episodios'])

    @endif
</div>


@endsection
