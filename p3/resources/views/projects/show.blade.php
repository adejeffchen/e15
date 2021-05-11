@extends('layouts/main')

@section('title')
Project Detail
@endsection

@section('content')
<div class="jumbotron">
    <h2 dusk="project-name-heading" class="display-4">{{ $project->name }}</h2>
    <p class="lead">Project Manager: {{ $project->project_manager }}</p>
    <hr class="my-4">
    <div>{!! nl2br(e($project->description)) !!}</div>
    @if(Auth::user())
    <a dusk="edit-project-button" class="btn btn-primary mt-3" href="/projects/{{ $project->id }}/edit" role="button">Edit project</a>
    @endif
</div>

{{-- Releases section --}}
<div class="container-fluid border bg-light rounded p-3  mb-3">
    <h2>Releases</h2>
    <div class="container-fluid">
        @if($releases->isEmpty())
        <div dusk="no-release-div">No release defined yet.</div>
        @endif

        @foreach ($releases as $release)
        <div class="row">
            <div class="col">
                <a dusk="release-link" href="/releases/{{ $release->id }}" class="p-3 mb-2 btn btn-outline-primary btn-block lead text-left">
                    {{$release->name}}
                </a>
            </div>
            <div class="col col-6">
                @if ($release->status === "On Track")
                <div dusk="release-status" class="p-3 mb-2 bg-success text-white rounded lead">{{$release->status}}</div>
                @elseif ($release->status === "At Risk")
                <div dusk="release-status" class="p-3 mb-2 bg-warning text-dark rounded lead">{{$release->status}}</div>
                @else
                <div dusk="release-status" class="p-3 mb-2 bg-danger text-white rounded lead">{{$release->status}}</div>
                @endif
            </div>
            <div class="col col-4">
                <div class="p-3 mb-2 bg-light text-dark rounded lead">
                    {{$release->release_date_display()}}
                </div>
            </div>
        </div>
        @endforeach

        {{-- Add release button --}}
        @if(Auth::user())
        <a dusk="add-release-button" class="btn btn-primary" href="/releases/create?project_id={{ $project->id }}" role="button">Add release</a>
        @endif
    </div>
</div>

@endsection
