@extends('layouts/main')

@section('title')
Edit Dependencies
@endsection

@section('content')
<h2 dusk="edit-dependencies-heading">Select dependencies for {{$this_release->project->name}} - {{ $this_release->name }}</h2>

@if($all_releases->isEmpty())
<div dusk="no-dependencies-div">No release has earlier release date.</div>
@else
<form method="POST" action="/dependencies/{{$this_release->id}}">
    {{ csrf_field() }}
    {{ method_field('put') }}

    {{-- Select dependencies section --}}
    <div class="form-group">
        @foreach($all_releases as $release)
        @if(in_array($release->id, $dependencies_ids))
        <div class="form-check my-2 lead">
            <input type="checkbox" class="form-check-input" name="dependencies[]" value="{{$release->id}}" id="{{$release->id}}" checked>
            <label class="form-check-label" for="{{$release->id}}">{{$release->project->name}} - {{$release->name}}</label>
        </div>
        @else
        <div class="form-check my-2 lead">
            <input type="checkbox" class="form-check-input" name="dependencies[]" value="{{$release->id}}" id="{{$release->id}}">
            <label class="form-check-label" for="{{$release->id}}">{{$release->project->name}} - {{$release->name}}</label>
        </div>
        @endif
        @endforeach
    </div>
    <button dusk="save-dependencies-button" type="submit" class="btn btn-primary">Save</button>
</form>
@endif
@endsection
