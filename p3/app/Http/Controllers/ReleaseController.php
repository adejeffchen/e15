<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Release;

class ReleaseController extends Controller
{
    /**
     * GET /releases/{id}
     * Show the release detail
     */
    public function show($id)
    {
        $release = Release::where('id', '=', $id)->first();
        return view('releases/show', ['release' => $release]);
    }

    /**
     * GET /releases/create
     * Show the form to add a release
     */
    public function create()
    {
        $projects = Project::all();
        return view('releases/create', [
            'projects' => $projects
        ]);
    }

    /**
    * POST /releases
    * Process the form for adding a new release
    */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'projectId' => 'required',
            'releaseName' => 'required|max:255',
            'releaseDescription' => 'max:65535'
        ]);
        // when failed, redirect back to '/releases/create'

        $release = new Release();
        $release->name = $request->input('releaseName');
        $release->status = "On Track";
        
        $date=date_create();
        if ($request->input('day') == 0) {
            date_date_set($date, $request->input('year'), $request->input('month'), 1);
            $release->release_date = date_format($date, "Y-m-d");
            $release->day_confirmed = false;
        } else {
            date_date_set($date, $request->input('year'), $request->input('month'), $request->input('day'));
            $release->release_date = date_format($date, "Y-m-d");
            $release->day_confirmed = true;
        }

        $release->description = $request->input('releaseDescription');

        // set the foreign id
        $project = Project::where('id', '=', $request->input('projectId'))->first();
        $release->project()->associate($project);
        $release->save();

        return redirect('/')->with([
            'flash-status' => 'Release created successfully'
        ]);
    }
}