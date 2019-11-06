@extends('layouts.web')

@section('content')

@section('breadcrumbs')
    {{ Breadcrumbs::render('shows', $category) }}
@endsection

@include('partials.shows')

@endsection
