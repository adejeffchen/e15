@extends('layouts/main')

@section('title')
Edit Release
@endsection

@section('content')
<h2 dusk="edit-release-heading">Edit Release</h2>
<form method="POST" action="/releases/{{$release->id}}">
    {{ csrf_field() }}
    {{ method_field('put') }}
    {{-- Disable Project Field --}}
    <div class="form-group">
        <label for="projectId">For Project</label>
        <select class="form-control" id="projectId" name="projectId" disabled>
            <option value={{$release->project->id}} selected="selected">{{$release->project->name}}</option>
        </select>
    </div>
    {{-- Release Name --}}
    <div class="form-group">
        <label for="releaseName">Release Name</label>
        <input dusk="release-name-input" class="form-control" id="releaseName" name="releaseName" value={{old("releaseName", $release->name)}}>
        {{-- if validation fails --}}
        @if($errors->get('releaseName'))
        <div dusk="release-name-error" class='text-danger'>{{ $errors->first('releaseName') }}</div>
        @endif
    </div>
    {{-- Release Status --}}
    <div class="form-group">
        <label>Status</label>
        <div class="form-check form-check-inline">
            @if(old("releaseStatus", $release->status)=="On Track")
            <input class="form-check-input" type="radio" name="releaseStatus" id="releaseStatus1" value="On Track" checked>
            @else
            <input class="form-check-input" type="radio" name="releaseStatus" id="releaseStatus1" value="On Track">
            @endif
            <label class="form-check-label bg-success text-white p-1 rounded" for="releaseStatus1">
                On Track
            </label>
        </div>
        <div class="form-check form-check-inline">
            @if(old("releaseStatus", $release->status)=="At Risk")
            <input class="form-check-input" type="radio" name="releaseStatus" id="releaseStatus2" value="At Risk" checked>
            @else
            <input class="form-check-input" type="radio" name="releaseStatus" id="releaseStatus2" value="At Risk">
            @endif
            <label class="form-check-label bg-warning text-white p-1 rounded" for="releaseStatus2">
                At Risk
            </label>
        </div>
        <div class="form-check form-check-inline">
            @if(old("releaseStatus", $release->status)=="Needs Attention")
            <input class="form-check-input" type="radio" name="releaseStatus" id="releaseStatus3" value="Needs Attention" checked>
            @else
            <input class="form-check-input" type="radio" name="releaseStatus" id="releaseStatus3" value="Needs Attention">
            @endif
            <label class="form-check-label bg-danger text-white p-1 rounded" for="releaseStatus3">
                Needs Attention
            </label>
        </div>
    </div>
    {{-- Release Date --}}
    <div class="form-group">
        <label>Release Date</label>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="year">Year</label>
                    <select class="form-control" id="year" name="year">
                        @for ($i = 2021; $i < 2026; $i++) @if ($i==old("year", date('Y', strtotime($release->release_date)))) <option value={{$i}} selected="selected">{{$i}}</option>
                            @else
                            <option value={{$i}}>{{$i}}</option>
                            @endif
                            @endfor
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="month">Month</label>
                    <select class="form-control" id="month" name="month">
                        @for ($i = 1; $i < 13; $i++) @if ($i==old("month", date('n', strtotime($release->release_date)))) <option value={{$i}} selected="selected">{{$i}}</option>
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
                        @if (!$release->day_confirmed)
                        <option value=0 selected="selected">Unknown</option>
                        @for ($i = 1; $i < 32; $i++) <option value={{$i}}>{{$i}}</option>
                            @endfor
                            @else
                            <option value=0>Unknown</option>
                            @for ($i = 1; $i < 32; $i++) @if ($i==old("day", date('j', strtotime($release->release_date)))) <option value={{$i}} selected="selected">{{$i}}</option>
                                @else
                                <option value={{$i}}>{{$i}}</option>
                                @endif
                                @endfor
                                @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    {{-- Release Description --}}
    <div class="form-group">
        <label for="releaseDescription">Release Description</label>
        <textarea dusk="release-description-input" class="form-control" id="releaseDescription" name="releaseDescription" rows="3">{{old("releaseDescription", $release->description)}}</textarea>
    </div>
    <button dusk="edit-release-button" type="submit" class="btn btn-outline-primary">Save</button>
</form>

@endsection
