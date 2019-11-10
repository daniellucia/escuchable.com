<li>
<a href="{{ route('episode.view', [$item->parentShow(), $item]) }}">
    @if ($item->parentShow()->thumbnail != '')
        <p class="Thumb">
        <img src="{{ asset($item->parentShow()->thumbnail) }}" alt="{{ $item->parentShow()->name }}" />
        </p>
    @endif
    <p>{!! $item->title !!}</p>
    <p class="Author">en <strong>{{ $item->parentShow()->name}}</strong></p>
    <div class="Metas">
        <p>
        <small>{{ $item->published }}</small>
        </p>
    </div>
</a>
</li>
