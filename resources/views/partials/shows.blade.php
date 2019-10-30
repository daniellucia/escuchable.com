<div class="shows">

    @if (!empty($shows))
        <h3>{{$category->name}}</h3>
        <ul>
        @foreach ($shows as $show)
            <li>
                <p class="image"><img src="{{ asset($show->image) }}" alt="{{ $show->name }}" /></p>
                <p><a href="{{ route('show.view', [$category, $show]) }}"><strong>{{ $show->name }}</strong></a></p>
                <p>{{ Str::limit(strip_tags($show->description), 100) }}</p>
            </li>
        @endforeach
        </ul>
    @endif
</div>
