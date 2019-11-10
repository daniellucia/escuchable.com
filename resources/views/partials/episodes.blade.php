<div class="Episodes">

    @yield('breadcrumbs')

    @if (!empty($episodes))

        <div class="ShowDescription Sticky">
            <div class="HeaderTitle">
                <h1>{{$show->name}}</h1>
                <p class="Back">
                    @can('edit show')
                    <a class="Button" href="{{ route('show.edit', $show)}}">Editar</a>
                    @endcan
                    <a class="Button" href="{{ route('category.view', [$category])}}">Volver</a>
                </p>
            </div>
            <div class="Description">
                <p>{!! $show->description !!}</p>
            </div>
        </div>

        @include('partials.pagination', ['element' => $episodes, 'text' => 'episodios'])

        <ul class="episodesList">
        @foreach ($episodes as $item)
            @include('episodes.detail')
        @endforeach
        </ul>
        @include('partials.pagination', ['element' => $episodes, 'text' => 'episodios'])

    @endif

</div>
