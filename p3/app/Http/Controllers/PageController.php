<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Release;

class PageController extends Controller
{
    /**
     * GET /
     * Show home page
     */
    public function index()
    {
        $projects = Project::all();
        $releases = Release::with('project')->get();

        // create a 2 dimentions array of ["project id" => [array of size 12, each contains the release or ""]]
        $months_array = ["", "", "", "", "", "", "", "", "", "", "", ""];
        $projects_releases_array = array();
        foreach ($projects as $project) {
            $months_array = ["", "", "", "", "", "", "", "", "", "", "", ""];
            //$projects_releases_array[] = [ $project['id'] => $months_array ];
            foreach ($releases as $release) {
                $release_month = date('n', strtotime($release['release_date']));
                if ($release['project_id']==$project['id']) {
                    $months_array[$release_month-1] = $release;
                }
            }
            $projects_releases_array[$project['id']] = $months_array;
        }
        
        return view('pages/home', [
            'projects' => $projects,
            'projects_releases' => $projects_releases_array
        ]);
    }
}