<div class="shows">

    @if (!empty($category->shows))
        <h3 class="sticky">{{$category->name}}</h3>
        <ul>
        @foreach ($category->shows as $program)
            <li>
                @if ($program->thumbnail != '')
                <p class="image"><img width="40" height="40" src="{{ asset($program->thumbnail) }}" alt="{{ $program->name }}" /></p>
                @endif

                <h5><a href="{{ route('show.view', [$category, $program]) }}">{{ $program->name }}</a></h5>
                <p>{{ Str::limit(strip_tags($program->description), 100) }}</p>
            </li>
        @endforeach
        </ul>
    @endif
</div>
