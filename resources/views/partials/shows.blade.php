<div class="Shows">

    @if (!empty($shows))
        <h3 class="Sticky">{{$category->name}}</h3>

        {{ $shows->links() }}
        <ul>
        @foreach ($shows as $showItem)
            <li class="ShowSummary @if(isset($show) && $showItem == $show) Selected @endif" id="{{ $showItem->slug }}">
                <a href="{{ route('show.view', [$category, $showItem, 'page-show' => app('request')->input('page-show'), '#'.$showItem->slug]) }}">
                    @if ($showItem->thumbnail != '')
                    <p class="Image"><img width="40" height="40" src="{{ asset($showItem->thumbnail) }}" alt="{{ $showItem->name }}" /></p>
                    @endif

                    <h5>{{ $showItem->name }}</h5>
                    <p class="Description">
                    {{ Str::limit(strip_tags($showItem->description), 110) }}
                    </p>
                </a>
            </li>
        @endforeach
        </ul>
        {{ $shows->links() }}
    @endif
</div>
