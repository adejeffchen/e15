@extends('layouts/main')

@section('title')
Add a Release
@endsection

@section('content')
<h2 dusk="create-release-heading">Add a Release</h2>
<form method="POST" action="/releases">
    {{ csrf_field() }}
    {{-- Select a Project --}}
    <div class="form-group">
        <label for="projectId">Select a Project</label>
        <select class="form-control" id="projectId" name="projectId">
            @foreach($projects as $project)
            @if ($project->id == old("projectId"))
            <option value={{$project->id}} selected="selected">{{$project->name}}</option>
            @else
            <option value={{$project->id}}>{{$project->name}}</option>
            @endif
            @endforeach
        </select>
    </div>
    {{-- Release Name --}}
    <div class="form-group">
        <label for="releaseName">Release Name</label>
        <input dusk="release-name-input" class="form-control" id="releaseName" name="releaseName" value={{old("releaseName")}}>
        {{-- if validation fails --}}
        @if($errors->get('releaseName'))
        <div dusk="release-name-error" class='text-danger'>{{ $errors->first('releaseName') }}</div>
        @endif
    </div>
    <div class="form-group">
        <label>Release Date</label>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="year">Year</label>
                    <input class="form-control" id="year" name="year" placeholder="e.g. 2021" value={{old("year", 2021)}}>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="month">Month</label>
                    <select class="form-control" id="month" name="month">
                        @for ($i = 1; $i < 13; $i++) @if ($i==old("month")) <option value={{$i}} selected="selected">{{$i}}</option>
                            @else
                            <option value={{$i}}>{{$i}}</option>
                            @endif
                            @endfor
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="day">Day</label>
                    <select class="form-control" id="day" name="day">
                        <option value=0>Unknown</option>
                        @for ($i = 1; $i < 32; $i++) @if ($i==old("day")) <option value={{$i}} selected="selected">{{$i}}</option>
                            @else
                            <option value={{$i}}>{{$i}}</option>
                            @endif
                            @endfor
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="releaseDescription">Release Description</label>
        <textarea class="form-control" id="releaseDescription" name="releaseDescription" rows="3">{{old("releaseDescription")}}</textarea>
    </div>
    <button dusk="create-release-button" type="submit" class="btn btn-outline-primary">Add Release</button>
</form>

@endsection
