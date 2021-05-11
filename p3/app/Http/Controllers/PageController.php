<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Release;
use DateTime;

class PageController extends Controller
{
    /**
     * GET /
     * Show home page
     */
    public function index()
    {
        // get date range for the home page, from current month + 11 months
        // set timezone to west coast
        date_default_timezone_set("America/Los_Angeles");
        $current_month_1st_str = date("Y-m-01");
        $after_11_month_date = new DateTime();
        date_add($after_11_month_date, date_interval_create_from_date_string("11 month"));
        // return the last day of the month
        $after_11_month_date_str = $after_11_month_date->format('Y-m-t');
        

        $projects = Project::all();
        $releases = Release::with('project')->where([
            ['release_date', '>', $current_month_1st_str],
            ['release_date', '<=', $after_11_month_date_str]
            ])->get();

        // calculate the 'month, year' for the 12 months header row
        $months_year_header = [];
        $header_date = new DateTime();
        $months_year_header[] = $header_date->format('M, Y');
        for ($monthCount=0; $monthCount<11; $monthCount++) {
            $months_year_header[] = date_add($header_date, date_interval_create_from_date_string("1 month"))->format('M, Y');
        }

        // create a 2 dimentions array of ["project id" => [array of size 12, each contains the release or ""]]
        $projects_releases_array = array();
        foreach ($projects as $project) {
            $months_array = ["", "", "", "", "", "", "", "", "", "", "", ""];
            $currentMonth = date("n");
            foreach ($releases as $release) {
                $release_month = date('n', strtotime($release['release_date']));
                if ($release['project_id']==$project['id']) {
                    if ($release_month >= $currentMonth) {
                        $months_array[$release_month-$currentMonth] = $release;
                    } else {
                        $months_array[$release_month+12-$currentMonth] = $release;
                    }
                }
            }
            $projects_releases_array[$project['id']] = $months_array;
        }
        
        return view('pages/home', [
            'projects' => $projects,
            'projects_releases' => $projects_releases_array,
            'months_year_header' => $months_year_header
        ]);
    }

    /**
     * GET /search
     * Show search result page
     */
    public function search(Request $request)
    {
        $search_term = $request->input('search_term');
        
        if ($search_term=="") {
            $search_results_projects = collect([]);
            $search_results_releases = collect([]);
        } else {
            // search project name and description
            $search_results_projects = Project::where('name', 'LIKE', '%'.$search_term.'%')
                ->orWhere('description', 'LIKE', '%'.$search_term.'%')
                ->get();
            // search release name and description
            $search_results_releases = Release::with('project')
                ->where('name', 'LIKE', '%'.$search_term.'%')
                ->orWhere('description', 'LIKE', '%'.$search_term.'%')
                ->get();
        }
        return view('pages/search', [
            'search_term' => $search_term,
            'search_results_projects' => $search_results_projects,
            'search_results_releases' => $search_results_releases,
        ]);
    }
}