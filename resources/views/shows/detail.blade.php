<li class="ShowSummary @if(isset($show) && $item == $show) Selected @endif" id="{{ $item->slug }}">
    <a href="{{ route('show.view', $item) }}">
        @if ($item->thumbnail != '')
        <p class="Image"><img src="{{ asset($item->image) }}" alt="{{ $item->name }}" /></p>
        @endif

        <h5>{{ $item->name }}</h5>
        <p class="Description">
        {{ Str::limit(strip_tags($item->description), 110) }}
        </p>
        <div class="Metas">
            <p>
            <small>{{ $item->last_episode }}</small>
            </p>
        </div>
    </a>

    @if(auth()->user()->can('show.edit'))
    <div class="Metas">
        <a class="Button" href="{{ route('show.edit', $item)}}">Editar</a>
    </div>
    @endif
</li>
