@extends('layouts/main')

@section('content')

@if (session('flash-status'))
<div dusk="success-div" class="alert alert-success">
    {{ session('flash-status') }}
</div>
@endif
@if (session('flash-status-error'))
<div dusk="error-div" class="alert alert-danger">
    {{ session('flash-status-error') }}
</div>
@endif

<div class="cal-table">
    <table class="table table-borderless release-table table-hover" id="month-table">
        <thead class="bg-secondary text-white">
            <tr class="header-row">
                <th scope="col" class="month-row col-project-title">Projects</th>
                @foreach($months_year_header as $months_year)
                <th scope="col" class="month-row">{{$months_year}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
            <tr class="non-header-row">
                <th class="headcol"><a dusk="project-{{$project->name}}" href="/projects/{{ $project->id }}">{{ $project->name }}</a></th>
                @foreach($projects_releases[$project->id] as $release)
                @if($release=="")
                <td></td>
                @else
                <td>
                    @if($release->status=="On Track")
                    <a dusk="release-{{$release->name}}" href="/releases/{{ $release->id }}" class="btn bg-success text-white btn-sm btn-block">
                        {{$release->name}} <br />
                        @if ($release->day_confirmed)
                        {{date('M j', strtotime($release->release_date))}}
                        @else
                        {{date('M', strtotime($release->release_date))}} ?
                        @endif
                    </a>
                    @elseif($release->status=="At Risk")
                    <a dusk="release-{{$release->name}}" href="/releases/{{ $release->id }}" class="btn bg-warning text-white btn-sm btn-block">
                        {{$release->name}} <br />
                        @if ($release->day_confirmed)
                        {{date('M j', strtotime($release->release_date))}}
                        @else
                        {{date('M', strtotime($release->release_date))}} ?
                        @endif
                    </a>
                    @elseif($release->status=="Needs Attention")
                    <a dusk="release-{{$release->name}}" href="/releases/{{ $release->id }}" class="btn bg-danger text-white btn-sm btn-block">
                        {{$release->name}} <br />
                        @if ($release->day_confirmed)
                        {{date('M j', strtotime($release->release_date))}}
                        @else
                        {{date('M', strtotime($release->release_date))}} ?
                        @endif
                    </a>
                    @endif
                </td>
                @endif
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
