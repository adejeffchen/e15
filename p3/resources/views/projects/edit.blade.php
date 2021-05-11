@extends('layouts/main')

@section('title')
Edit Project Detail
@endsection

@section('content')
<h2 dusk="edit-project-heading">Edit Project</h2>
<form method="POST" action="/projects/{{$project->id}}">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="form-group">
        <label for="projectName">Project Name</label>
        <input dusk="project-name-input" class="form-control" id="projectName" name="projectName" value="{{old("projectName", $project->name)}}">
        {{-- if validation fails --}}
        @if($errors->get('projectName'))
        <div dusk="project-name-error" class='text-danger'>{{ $errors->first('projectName') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label for="projectManager">Project Manager</label>
        <input type="text" dusk="project-manager-input" class="form-control" id="projectManager" name="projectManager" value="{{old("projectManager", $project->project_manager)}}">
        {{-- if validation fails --}}
        @if($errors->get('projectManager'))
        <div dusk="project-manager-error" class='text-danger'>{{ $errors->first('projectManager') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label for="projectDescription">Project Description</label>
        <textarea class="form-control" id="projectDescription" name="projectDescription" rows="3">{{old("projectDescription", $project->description)}}</textarea>
    </div>
    <button dusk="edit-project-button" type="submit" class="btn btn-outline-primary">Save</button>
</form>

@endsection
