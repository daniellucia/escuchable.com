<div class="shows">
    <h3>{{$category->name}}</h3>
    @if (!empty($shows))
        @foreach ($shows as $show)
            <p><a href="{{ route('show.view', [$category, $show]) }}">{{ $show->name }}</a></p>
        @endforeach
    @endif
</div>
