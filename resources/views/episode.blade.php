@extends('layouts.web')

@section('content')

@section('breadcrumbs')
    {{ Breadcrumbs::render('episode', $show, $episode) }}
@endsection

@include('partials.episode')

@endsection
