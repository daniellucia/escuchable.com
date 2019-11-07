@extends('layouts.web')

@section('content')

@section('breadcrumbs')
    {{ Breadcrumbs::render('home') }}
@endsection

<div class="Home">
    @include('partials.categories')

    {{ Widget::recentEpisodes() }}
</div>

@endsection
