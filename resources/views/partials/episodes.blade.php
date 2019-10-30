<div class="episodes">
    @if (!empty($episodes))
        <h1>{{$show->name}}</h1>
        {{ $episodes->links() }}

        @foreach ($episodes as $episode)
            <p><a href="{{ route('episode.view', [$category, $show, $episode]) }}">{{ $episode->title }}</a></p>
        @endforeach

        {{ $episodes->links() }}

    @endif
</div>
