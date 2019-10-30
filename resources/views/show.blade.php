@extends('layouts.web')

@section('content')

<div class="shows">
    <h3>{{$category->name}}</h3>

    @include('partials.shows')

    <h1>{{$show->name}}</h1>
    @include('partials.episodes')
</div>

@endsection
