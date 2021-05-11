<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * GET /projects/create
     * Show the form to add a proejct
     */
    public function create()
    {
        return view('projects/create');
    }

    /**
     * GET /projects/{id}
     * Show the project detail
     */
    public function show($id)
    {
        $project = Project::where('id', '=', $id)->first();
        $releases = $project->releases->sortBy('release_date');
        return view('projects/show', [
            'project' => $project,
            'releases' => $releases
            ]);
    }

    /**
     * GET /projects/{id}/edit
     * Show the project detail edit page
     */
    public function edit($id)
    {
        $project = Project::where('id', '=', $id)->first();

        if (!$project) {
            return redirect('/')->with([
                'flash-status-error' => 'Project does not exist'
            ]);
        }

        return view('projects/edit', [
            'project' => $project,
            ]);
    }

    /**
     * PUT /projects/{id}
     * Save the project detail edit
     */
    public function update(Request $request, $id)
    {
        $project = Project::where('id', '=', $id)->first();

        // validate
        $request->validate([
            'projectName' => 'required|max:255|unique:projects,name,'.$project->id,
            'projectManager' => 'required|max:255',
            'projectDescription' => 'max:65535',
        ]);

        $project->name = $request->projectName;
        $project->project_manager = $request->projectManager;
        $project->description = $request->projectDescription;
        $project->save();

        $releases = $project->releases->sortBy('release_date');
        return view('projects/show', [
            'project' => $project,
            'releases' => $releases
            ]);
    }

    /**
    * POST /projects
    * Process the form for adding a new project
    */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'projectName' => 'required|max:255|unique:projects,name',
            'projectManager' => 'required|max:255',
            'projectDescription' => 'max:65535',
        ]);
        // when failed, redirect back to '/projects/create'

        $project = new Project();
        $project->name = $request->input('projectName');
        $project->project_manager = ucwords(strtolower($request->input('projectManager')));
        $project->description = $request->input('projectDescription');
        $project->save();

        return redirect('/')->with([
            'flash-status' => 'Project created successfully'
        ]);
    }
}