@if (!empty($episodesWidget))
<div class="EpisodesWidget">
<p class="Title">Últimos episodios</p>
    <ul>
    @foreach ($episodesWidget as $episodeItem)
        <li>
            <a href="{{ route('episode.view', [$episodeItem->parentShow(), $episodeItem]) }}">
                @if ($episodeItem->parentShow()->thumbnail != '')
                    <p class="Thumb">
                    <img src="{{ asset($episodeItem->parentShow()->thumbnail) }}" alt="{{ $episodeItem->parentShow()->name }}" />
                    </p>
                @endif
                <p><em>{{ $episodeItem->title }}</em> en <strong>{{ $episodeItem->parentShow()->name}}</strong></p>
                <div class="Metas">
                    <p>
                    <small>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($episodeItem->published))->diffForHumans() }}</small>
                    </p>
                </div>
            </a>
        </li>
    @endforeach
    </ul>
</div>
@endif
