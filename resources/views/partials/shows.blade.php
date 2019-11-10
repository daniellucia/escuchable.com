<div class="Shows">

    @yield('breadcrumbs')

    @if (!empty($shows))
        <div class="HeaderTitle">
            <h1 class="Sticky">{{$category->name}}</h1>
            <p class="Back">

                @can('edit category')
                <a class="Button" href="{{ route('categories.edit', $category)}}">Editar</a>
                @endcan

                <a class="Button" href="{{ route('home')}}">Volver</a>
            </p>
        </div>


        @include('partials.pagination', ['element' => $shows, 'text' => 'shows'])

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

        @include('partials.pagination', ['element' => $shows, 'text' => 'shows'])
    @endif
</div>
