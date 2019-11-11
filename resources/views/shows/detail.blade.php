<li class="ShowSummary @if(isset($show) && $item == $show) Selected @endif" id="{{ $item->slug }}">
    <a href="{{ route('show.view', $item) }}">
        @if ($item->thumbnail != '')
        <p class="Image"><img src="{{ asset($item->image) }}" alt="{{ $item->name }}" /></p>
        @endif

        <h5>{{ $item->name }}</h5>
        <p class="Description">
        {{ Str::limit(strip_tags($item->description), 110) }}
        </p>
        <div class="Metas">
            <p>
            <small>{{ $item->last_episode }}</small>
            </p>
        </div>
    </a>

    @can('show.edit')
        <form method="POST" action="{{ route('show.edit', $item) }}" class="Form Ajax">
            @csrf
            <div class="Control">
                <label for="feed">{{ __('Categoria') }}</label>
                <select name="category">
                    @foreach ($categories as $itemCategory)
                    <option value="{{ $itemCategory->id }}" @if($itemCategory->id == $item->categories_id) selected @endif>{{ ucfirst($itemCategory->name) }}</option>
                    @endforeach
            </select>
            </div>

            <div class="Control">
                <button type="submit" class="Button">
                    {{ __('Guardar') }}
                </button>
            </div>
        </form>
    @endcan
</li>
