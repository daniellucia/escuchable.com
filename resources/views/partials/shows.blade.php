<div class="Shows">

    @if (!empty($shows))

        <p class="Back"><a href="{{ route('home')}}">Volver</a></p>
        <h3 class="Sticky">{{$category->name}}</h3>


        {{ $shows->links() }}

        <ul class="List">
        @foreach ($shows as $showItem)
            <li class="ShowSummary @if(isset($show) && $showItem == $show) Selected @endif" id="{{ $showItem->slug }}">
                <a href="{{ route('show.view', $showItem) }}">
                    @if ($showItem->thumbnail != '')
                    <p class="Image"><img src="{{ asset($showItem->image) }}" alt="{{ $showItem->name }}" /></p>
                    @endif

                    <h5>{{ $showItem->name }}</h5>
                    <p class="Description">
                    {{ Str::limit(strip_tags($showItem->description), 110) }}
                    </p>
                    <div class="Metas">
                        <p>
                        <small>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($showItem->last_episode))->diffForHumans() }}</small>
                        </p>
                    </div>
                </a>
            </li>
        @endforeach
        </ul>

        {{ $shows->links() }}
    @endif
</div>
