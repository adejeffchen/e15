@extends('layouts/main')

@section('title')
Release Detail
@endsection

@section('content')

<h2 dusk="release-name-heading" class="display-4">{{$release->project->name}} - {{ $release->name }}
    {{-- Edit release button --}}
    @if(Auth::user())
    <a dusk="edit-release-button" class="btn btn-primary" href="/releases/{{$release->id}}/edit" role="button">Edit release</a>
    @endif
</h2>

{{-- Release detail section --}}
<div class="container-fluid border rounded p-3 mb-3">
    <div class="row">
        <div class="col col-lg-2">
            <h4 class="p-3 mb-2">Status</h4>
        </div>
        <div class="col">
            @if ($release->status === "On Track")
            <div dusk="release-status" class="p-3 mb-2 bg-success text-white rounded lead">{{$release->status}}</div>
            @elseif ($release->status === "At Risk")
            <div dusk="release-status" class="p-3 mb-2 bg-warning text-dark rounded lead">{{$release->status}}</div>
            @else
            <div dusk="release-status" class="p-3 mb-2 bg-danger text-white rounded lead">{{$release->status}}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-2">
            <h4 class="p-3 mb-2">Release date</h4>
        </div>
        <div class="col">
            <div dusk="release-date" class="p-3 mb-2 text-dark rounded lead">
                {{$release->release_date_display()}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-2">
            <h4 class="p-3 mb-2">Description</h4>
        </div>
        <div class="col">
            <div class="p-3 mb-2 text-dark rounded lead">
                {{$release->description}}
            </div>
        </div>
    </div>
</div>

{{-- dependencies listing section --}}
<div class="container-fluid border bg-light rounded p-3  mb-3">
    <h4 dusk="release-dependencies-heading" class="my-3">Release Dependencies</h4>

    @if($release->dependencies->isEmpty())
    <div dusk="no-dependencies-div" class="my-3">No dependencies yet.</div>
    @endif

    @foreach($release->dependencies->sortBy('release_date') as $dependent_release)
    <div class="row">
        <div class="col-3">
            <a dusk="dependencies-project-link" href="/projects/{{ $dependent_release->project->id }}" class="p-3 mb-2 btn btn-outline-primary btn-block lead text-left">
                {{$dependent_release->project->name}}
            </a>
        </div>
        <div class="col">
            <a dusk="dependencies-release-link" href="/releases/{{ $dependent_release->id }}" class="p-3 mb-2 btn btn-outline-primary btn-block lead text-left">
                {{$dependent_release->name}}
            </a>
        </div>
        <div class="col col-3">
            @if ($dependent_release->status === "On Track")
            <div dusk="dependencies-release-status" class="p-3 mb-2 bg-success text-white rounded lead">{{$dependent_release->status}}</div>
            @elseif ($dependent_release->status === "At Risk")
            <div dusk="dependencies-release-status" class="p-3 mb-2 bg-warning text-dark rounded lead">{{$dependent_release->status}}</div>
            @else
            <div dusk="dependencies-release-status" class="p-3 mb-2 bg-danger text-white rounded lead">{{$dependent_release->status}}</div>
            @endif
        </div>
        <div class="col col-4">
            <div class="p-3 mb-2 bg-light text-dark rounded lead">
                {{$dependent_release->release_date_display()}}
            </div>
        </div>
    </div>
    @endforeach


    {{-- Edit dependencies button --}}
    @if(Auth::user())
    <a dusk="edit-dependencies-button" class="btn btn-primary" href="/dependencies/{{$release->id}}/edit" role="button">Edit dependencies</a>
    @endif
</div>

{{-- Prerequisite of listing section --}}
<div class="container-fluid border bg-light rounded p-3  mb-3">
    <h4 dusk="blocks-heading" class="my-3">Prerequisite of</h4>

    @if($release->blocks->isEmpty())
    <div dusk="no-blocks-div" class="my-3">None</div>
    @endif

    @foreach($release->blocks->sortBy('release_date') as $blocking_release)
    <div class="row">
        <div class="col-3">
            <a dusk="blocks-project-link" href="/projects/{{ $blocking_release->project->id }}" class="p-3 mb-2 btn btn-outline-primary btn-block lead text-left">
                {{$blocking_release->project->name}}
            </a>
        </div>
        <div class="col">
            <a dusk="blocks-release-link" href="/releases/{{ $blocking_release->id }}" class="p-3 mb-2 btn btn-outline-primary btn-block lead text-left">
                {{$blocking_release->name}}
            </a>
        </div>
        <div class="col col-3">
            @if ($blocking_release->status === "On Track")
            <div dusk="blocks-release-status" class="p-3 mb-2 bg-success text-white rounded lead">{{$blocking_release->status}}</div>
            @elseif ($blocking_release->status === "At Risk")
            <div dusk="blocks-release-status" class="p-3 mb-2 bg-warning text-dark rounded lead">{{$blocking_release->status}}</div>
            @else
            <div dusk="blocks-release-status" class="p-3 mb-2 bg-danger text-white rounded lead">{{$blocking_release->status}}</div>
            @endif
        </div>
        <div class="col col-4">
            <div class="p-3 mb-2 bg-light text-dark rounded lead">
                {{$blocking_release->release_date_display()}}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
