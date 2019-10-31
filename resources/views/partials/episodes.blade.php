<div class="Episodes">
    @if (!empty($episodes))
        <div class="ShowDescription Sticky">
            <h1>{{$show->name}}</h1>
            <p>{!! $show->description !!}</p>
        </div>

        {{ $episodes->appends(['page-show' => app('request')->input('page-show')])->links() }}
        <ul>
        @foreach ($episodes as $episodeItem)
            <li><a href="{{ route('episode.view', [$category, $show, $episodeItem, 'page-episode' => app('request')->input('page-episode'), 'page-show' => app('request')->input('page-show')]) }}">{{ $episodeItem->title }}</a></li>
        @endforeach
        </ul>
        {{ $episodes->appends(['page-show' => app('request')->input('page-show')])->links() }}

    @endif
</div>
