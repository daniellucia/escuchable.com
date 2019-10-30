@if (!empty($episodes))

    {{ $episodes->links() }}

    @foreach ($episodes as $episode)
        <p><a href="{{ route('episode.view', [$category, $show, $episode]) }}">{{ $episode->title }}</a></p>
    @endforeach

    {{ $episodes->links() }}

@endif
