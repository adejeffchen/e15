@extends('layouts/main')

@section('content')

{{-- @if(Auth::user())
<h2>
    Hello {{ Auth::user()->name }}!
</h2>
@endif --}}

<h2>2021</h2>
@if (session('flash-status'))
<div dusk="success-div" class="alert alert-success">
    {{ session('flash-status') }}
</div>
@endif
<table class="table table-borderless" id="month-table">
    <thead class="bg-secondary text-white">
        <tr>
            <th scope="col">Projects</th>
            <th scope="col">Jan</th>
            <th scope="col">Feb</th>
            <th scope="col">March</th>
            <th scope="col">April</th>
            <th scope="col">May</th>
            <th scope="col">June</th>
            <th scope="col">July</th>
            <th scope="col">Aug</th>
            <th scope="col">Sept</th>
            <th scope="col">Oct</th>
            <th scope="col">Nov</th>
            <th scope="col">Dec</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
        <tr>
            <th><a dusk="project-{{$project->name}}" href="/projects/{{ $project->id }}">{{ $project->name }}</a></th>
            @foreach($projects_releases[$project->id] as $release)
            @if($release=="")
            <td></td>
            @else
            <td>
                <a dusk="release-{{$release->name}}" href="/releases/{{ $release->id }}" class="btn btn-outline-primary btn-sm">
                    {{$release->name}} <br />
                    {{date('M j', strtotime($release->release_date))}}
                </a>
            </td>
            @endif
            @endforeach

        </tr>
        @endforeach
    </tbody>
</table>

@endsection
