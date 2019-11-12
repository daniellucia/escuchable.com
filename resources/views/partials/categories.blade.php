@if (!empty($categories))
    <div class="Categories">
        <p class="Title">Categorías</p>
        <ul @if(isset($category)) class="categorySelected" @endif >
        @foreach ($categories as $item)
            @if ($item->shows()->count() > 0)
                <li id="{{ $item->slug }}" class=" @if(isset($category) && $item == $category) Selected @endif">
                    <a href="{{ route('category.view', $item) }}">
                        <span>
                            <em>{{ $item->shows()->count()}} shows</em>
                            {{ ucfirst($item->name) }}
                        </span>
                    </a>
                </li>
            @endif
        @endforeach
        </ul>
    </div>
@endif
