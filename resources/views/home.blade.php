@extends('layouts.web')

@section('content')

@section('breadcrumbs')
    {{ Breadcrumbs::render('home') }}
@endsection

<div class="Home">
    {{ Widget::recentEpisodes() }}
</div>

@endsection
