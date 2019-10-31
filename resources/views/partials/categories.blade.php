@if (!empty($categories))
    <div class="Categories">
        <p class="Title Sticky">Categorías</p>
        <ul>
        @foreach ($categories as $category)
            <li><a href="{{ route('category.view', $category) }}">{{ $category->name }}</a></li>
        @endforeach
        </ul>
    </div>
@endif
