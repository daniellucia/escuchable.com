@if ($element->total() > 0)
    <div class="PaginationContent">
        <p><strong>{{ $element->total() }}</strong> <em>{{$text}}</em></p>
        {{ $element->links() }}
    </div>
@endif
