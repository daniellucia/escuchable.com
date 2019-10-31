<div class="Shows">

    @if (!empty($category->shows))
        <h3 class="Sticky">{{$category->name}}</h3>
        <ul>
        @foreach ($category->shows as $program)
            <li class="ShowSummary">
                @if ($program->thumbnail != '')
                <p class="Image"><img width="40" height="40" src="{{ asset($program->thumbnail) }}" alt="{{ $program->name }}" /></p>
                @endif

                <h5><a href="{{ route('show.view', [$category, $program]) }}">{{ $program->name }}</a></h5>
                <p class="Description">{{ Str::limit(strip_tags($program->description), 110) }}</p>
            </li>
        @endforeach
        </ul>
    @endif
</div>
