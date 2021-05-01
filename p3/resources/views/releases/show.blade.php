@extends('layouts/main')

@section('title')
Release Detail
@endsection

@section('content')

<h2 dusk="release-name-heading" class="display-4">{{$release->project->name}} - {{ $release->name }}</h2>

<a class="btn btn-primary" href="#" role="button">Edit</a>

@endsection
