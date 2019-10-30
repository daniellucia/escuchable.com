@extends('layouts.web')

@section('content')
<div class="shows">
    <h1>{{$category->name}}</h1>

    @include('partials.shows')
</div>
@endsection
