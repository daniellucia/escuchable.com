<div class="Results">

    @if (!empty($results))

        <p class="Title Sticky">{{ $term }}</p>

        {{ $results->links() }}
        <ul>
        @foreach ($results as $result)
            <li class="ResultSummary type{{ucfirst($result->type)}}">
                <a href="{{ $result->url }}">
                    @if ($result->image != '')
                        <p class="Image">
                            <img width="40" height="40" src="{{ asset($result->image) }}" alt="{{ $result->name }}" />
                        </p>
                    @endif
                    <h5>{{ $result->search }}</h5>
                </a>
            </li>
        @endforeach
        </ul>
        {{ $results->links() }}
    @endif
</div>
