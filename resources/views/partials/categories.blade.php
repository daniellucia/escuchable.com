@if (!empty($categories))
    <div class="Categories">
        <ul @if(isset($category)) class="categorySelected" @endif >
        @foreach ($categories as $categoryItem)
            <li id="{{ $categoryItem->slug }}" class=" @if(isset($category) && $categoryItem == $category) Selected @endif">
                <a href="{{ route('category.view', $categoryItem) }}">{{ ucfirst($categoryItem->name) }}</a>
            </li>
        @endforeach
        </ul>
    </div>
@endif
