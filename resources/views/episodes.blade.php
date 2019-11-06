@extends('layouts.web')

@section('content')

@section('breadcrumbs')
    {{ Breadcrumbs::render('episodes', $show) }}
@endsection

@include('partials.episodes')

@endsection
