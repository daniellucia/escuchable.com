@extends('layouts.web')

@section('content')

@section('breadcrumbs')
    {{ Breadcrumbs::render('search') }}
@endsection

@include('partials.search')

@endsection
