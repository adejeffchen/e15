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
        $release = Release::with('dependencies', 'dependencies.project')->where('id', '=', $id)->first();

        return view('releases/show', [
            'release' => $release,
        ]);
    }

    /**
     * GET /releases/create
     * Show the form to add a release
     */
    public function create(Request $request)
    {
        // to pre-select a project during creation
        $project_id = $request->input('project_id');
        if ($project_id=="") {
            $project_id = null;
        }

        $projects = Project::all();
        return view('releases/create', [
            'projects' => $projects,
            'project_id' => $project_id
        ]);
    }

    /**
    * GET /releases/{id}/edit
    * Show the releases detail edit page
    */
    public function edit($id)
    {
        $release = Release::where('id', '=', $id)->first();

        if (!$release) {
            return redirect('/')->with([
                'flash-status-error' => 'Release does not exist'
            ]);
        }

        return view('releases/edit', [
            'release' => $release,
            ]);
    }

    /**
     * PUT /releases/{id}
     * Save the release detail edit
     */
    public function update(Request $request, $id)
    {
        $release = Release::where('id', '=', $id)->first();

        // validate
        $request->validate([
            'releaseName' => 'required|max:255,'.$release->id,
            'releaseDescription' => 'max:65535'
        ]);

        $release->name = $request->input('releaseName');

        $release->status = $request->input('releaseStatus');
        
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
        
        $release->save();

        return view('releases/show', [
            'release' => $release,
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