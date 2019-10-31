@if (!empty($categories))
    <div class="categories">
    <p class="title sticky">Categorías</p>
    <ul>
    @foreach ($categories as $category)
        <li><a href="{{ route('category.view', $category) }}">{{ $category->name }}</a></li>
    @endforeach
    </ul>
    </div>
@endif
