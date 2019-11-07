<div class="Episodes">
    @if (!empty($episodes))

        <div class="ShowDescription Sticky">
            <div class="HeaderTitle">
                <h1>{{$show->name}}</h1>
                <p class="Back"><a class="Button" href="{{ route('category.view', [$category])}}">Volver</a></p>
            </div>
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
