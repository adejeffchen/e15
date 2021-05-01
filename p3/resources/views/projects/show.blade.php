@extends('layouts/main')

@section('title')
Project Detail
@endsection

@section('content')
<div class="jumbotron">
    <h2 dusk="project-name-heading" class="display-4">{{ $project->name }}</h2>
    <p class="lead">Project Manager: {{ $project->project_manager }}</p>
    <hr class="my-4">
    <p>{{ $project->description }}</p>
    <a class="btn btn-primary" href="#" role="button">Edit</a>
</div>
@endsection
