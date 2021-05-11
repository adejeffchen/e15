<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Release;

class DependenciesController extends Controller
{
    /**
         * GET /dependencies/{id}/edit
         * Show the dependencies edit page
         */
    public function edit($id)
    {
        $this_release = Release::with('dependencies')->where('id', '=', $id)->first();
        
        // don't show self as a choice to select
        // only show releases that has date earlier than self's release date
        $allReleases = Release::with('project')->where([
            ['id', '!=', $this_release->id],
            ['release_date', '<=', $this_release->release_date]
            ])->get();
    
        if (!$this_release) {
            return redirect('/')->with([
                    'flash-status-error' => 'Release does not exist'
                ]);
        }

        // get the list of dependencies releases IDs
        $dependencies_ids = array();
        foreach ($this_release->dependencies as $release) {
            $dependencies_ids[] = $release->id;
        }
    
        return view('dependencies/edit', [
                'this_release' => $this_release,
                'all_releases' => $allReleases,
                'dependencies_ids' => $dependencies_ids
                ]);
    }

    /**
     * PUT /dependencies/{id}
     * Save the dependencies edit
     */
    public function update(Request $request, $id)
    {
        $this_release = Release::with('dependencies')->where('id', '=', $id)->first();
        
        $selected_release_ids = $request->input('dependencies');

        // delete all existing dependendencies
        foreach ($this_release->dependencies as $release) {
            $release->pivot->delete();
        }

        // save selected releases
        if (!empty($selected_release_ids)) {
            foreach ($selected_release_ids as $release_id) {
                $selected_release = Release::where('id', '=', $release_id)->first();
                $this_release->dependencies()->save($selected_release, [
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),]);
            }
        }

        return redirect('releases/'.$this_release->id);
    }
}