<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addThreeProjects();
    }

    private function addThreeProjects()
    {
        $project = new Project();
        $project->name = 'Skywalker';
        $project->project_manager = 'Jeff Chen';
        $project->description = 'Project Skywalker allows customers to purchase AppleCare from the Settings.';
        $project->save();

        $project2 = new Project();
        $project2->name = 'Modernize GetSupport';
        $project2->project_manager = 'Houston Wong';
        $project2->description = 'Redesign the end to end experience for GetSupport.';
        $project2->save();

        $project3 = new Project();
        $project3->name = 'Support App';
        $project3->project_manager = 'Sergio Lu';
        $project3->description = 'Adding new features to the existing Support App.';
        $project3->save();

        $project4 = new Project();
        $project4->name = 'Sky';
        $project4->project_manager = 'Jeff Chen';
        $project4->description = 'Cross functional project that promotes AppleCare and iCloud services.';
        $project4->save();
    }
}