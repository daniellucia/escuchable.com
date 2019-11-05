<div class="Episodes">
    @if (!empty($episodes))
        <p class="Back"><a href="{{ route('category.view', [$category])}}">Volver</a></p>
        <div class="ShowDescription Sticky">
            <h1>{{$show->name}}</h1>
            <p>{!! $show->description !!}</p>
        </div>

        {{ $episodes->links() }}
        <ul class="episodesList">
        @foreach ($episodes as $item)
            @include('episodes.detail')
        @endforeach
        </ul>
        {{ $episodes->links() }}

    @endif

</div>
