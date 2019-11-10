<div class="Shows">

    @yield('breadcrumbs')

    @if (!empty($shows))

        <p class="Title Sticky">{{ $term }}</p>

        @include('partials.pagination', ['element' => $shows, 'text' => 'shows'])

        <ul class="List">
        @foreach ($shows as $item)
            @include('shows.detail')
        @endforeach
        </ul>

        @include('partials.pagination', ['element' => $shows, 'text' => 'shows'])
    @endif
</div>
