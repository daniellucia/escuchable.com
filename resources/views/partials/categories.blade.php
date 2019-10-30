@if (!empty($categories))
    <div class="categories">
    @foreach ($categories as $category)
        <p><a href="{{ route('category.view', $category) }}">{{ $category->name }}</a></p>
    @endforeach
    </div>
@endif
