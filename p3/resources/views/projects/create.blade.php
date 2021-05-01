@extends('layouts/main')

@section('title')
Add a Project
@endsection

@section('content')
<h2 dusk="create-project-heading">Add a Project</h2>
<form method="POST" action="/projects">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="projectName">Project Name</label>
        <input dusk="project-name-input" class="form-control" id="projectName" name="projectName" value={{old("projectName")}}>
        {{-- if validation fails --}}
        @if($errors->get('projectName'))
        <div dusk="project-name-error" class='text-danger'>{{ $errors->first('projectName') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label for="projectManager">Project Manager</label>
        <input dusk="project-manager-input" class="form-control" id="projectManager" name="projectManager" value={{old("projectManager")}}>
        {{-- if validation fails --}}
        @if($errors->get('projectManager'))
        <div dusk="project-manager-error" class='text-danger'>{{ $errors->first('projectManager') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label for="projectDescription">Project Description</label>
        <textarea class="form-control" id="projectDescription" name="projectDescription" rows="3">{{old("projectDescription")}}</textarea>
    </div>
    <button dusk="create-project-button" type="submit" class="btn btn-outline-primary">Add Project</button>
</form>

@endsection
