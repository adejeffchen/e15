@extends('layouts/main')

@section('title')
Search Results
@endsection

@section('content')

{{-- search field --}}
<h2 dusk="search-results-heading">Search Results</h2>
<form class="form-inline my-2 my-lg-0 ml-auto" action='/search'>
    <input dusk="search-input" class="form-control mr-sm-2 w-25" type="search" placeholder="Search" aria-label="Search" name='search_term' value='{{ old('search_term', $search_term) }}'>
    <button dusk="search-button" class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
</form>

{{-- project search results section --}}
<h3 class="mt-3">Projects</h3>
<hr />
@if($search_results_projects->isEmpty())
<div dusk="search-results-projects-empty-heading">No project matching the search query.</div>
@endif
@foreach($search_results_projects as $project)
<div>
    <a dusk="search-results-project-name" href="/projects/{{ $project->id }}">{{$project->name}}</a>
    <p class="pl-3">Description: {{$project->description}}</p>
</div>
@endforeach

{{-- release search results section --}}
<h3 class="mt-3">Releases</h3>
<hr />
@if($search_results_releases->isEmpty())
<div dusk="search-results-releases-empty-heading">No release matching the search query.</div>
@endif
@foreach($search_results_releases as $release)
<div>
    <a dusk="search-results-release-name" href="/releases/{{ $release->id }}">{{$release->project->name}} - {{$release->name}}</a>
    <p class="pl-3">Description: {{$release->description}}</p>
</div>
@endforeach

@endsection
