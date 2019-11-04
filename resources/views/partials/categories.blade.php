@if (!empty($categories))
    <div class="Categories">
        <p class="Title Sticky">Categorías</p>
        <ul @if(isset($category)) class="categorySelected" @endif >
        @foreach ($categories as $categoryItem)
            <li id="{{ $categoryItem->slug }}" class=" @if(isset($category) && $categoryItem == $category) Selected @endif">
                <a href="{{ route('category.view', [$categoryItem, '#'.$categoryItem->slug]) }}">{{ ucfirst($categoryItem->name) }}</a>
            </li>
        @endforeach
        </ul>
    </div>
@endif
