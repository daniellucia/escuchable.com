<li>
<a href="{{ route('episode.view', [$item->show(), $item]) }}">

    @if (optional($item->show()->thumbnail))
        <p class="Thumb">
        <img src="{{ asset($item->show()->thumbnail) }}" alt="{{ $item->show()->name }}" />
        </p>
    @endif

    <p>{!! $item->title !!}</p>
    <p class="Author">en <strong>{{ $item->show()->name}}</strong></p>
    <div class="Metas">
        <p>
        <small>{{ $item->published }}</small>
        </p>
    </div>
</a>
</li>
