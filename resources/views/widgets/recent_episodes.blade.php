@if (!empty($episodesWidget))
<div class="EpisodesWidget">
<p class="Title">Últimos episodios</p>
    <ul class="episodesList">
    @foreach ($episodesWidget as $item)
        @include('episodes.detail')
    @endforeach
    </ul>
</div>
@endif
