<div class="Episodes">
    @if (!empty($episodes))
        <div class="ShowDescription Sticky">
            <h1>{{$show->name}}</h1>
            <p>{!! $show->description !!}</p>
        </div>

        {{ $episodes->links() }}
        <ul>
        @foreach ($episodes as $episode)
            <li><a href="{{ route('episode.view', [$category, $show, $episode]) }}">{{ $episode->title }}</a></li>
        @endforeach
        </ul>
        {{ $episodes->links() }}

    @endif
</div>
