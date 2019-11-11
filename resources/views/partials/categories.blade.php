@if (!empty($categories))
    <div class="Categories">
        <p class="Title">Categorías</p>
        <ul @if(isset($category)) class="categorySelected" @endif >
        @foreach ($categories as $categoryItem)
            <li id="{{ $categoryItem->slug }}" class=" @if(isset($category) && $categoryItem == $category) Selected @endif">
                <a href="{{ route('category.view', $categoryItem) }}">
                    <span>
                        <em>{{ $categoryItem->shows()->count()}} shows</em>
                        {{ ucfirst($categoryItem->name) }}
                    </span>
                </a>
            </li>
        @endforeach
        </ul>
    </div>
@endif
