<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Release;

class ReleasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addReleases();
    }

    private function addReleases()
    {
        $release1_1 = new Release();
        $release1_1->name = 'R1';
        $release1_1->status = 'On Track';
        $release1_1->release_date = '2021-3-5';
        $release1_1->day_confirmed = true;
        $release1_1->description = 'Feature: able to see AppleCare status in Settings.';
        $release1_1->project_id = 1;
        $release1_1->save();

        $release1_2 = new Release();
        $release1_2->name = 'R2';
        $release1_2->status = 'On Track';
        $release1_2->release_date = '2021-6-1';
        $release1_2->day_confirmed = false;
        $release1_2->description = 'Feature: able to buy AppleCare in Settings.';
        $release1_2->project_id = 1;
        $release1_2->save();

        $release2_1 = new Release();
        $release2_1->name = 'R2';
        $release2_1->status = 'On Track';
        $release2_1->release_date = '2021-7-15';
        $release2_1->day_confirmed = true;
        $release2_1->description = 'Solution options redesigned.';
        $release2_1->project_id = 2;
        $release2_1->save();

        $release2_2 = new Release();
        $release2_2->name = 'R1';
        $release2_2->status = 'On Track';
        $release2_2->release_date = '2021-2-4';
        $release2_2->day_confirmed = true;
        $release2_2->description = 'Infrastructure update.';
        $release2_2->project_id = 2;
        $release2_2->save();

        $release3_1 = new Release();
        $release3_1->name = 'R1';
        $release3_1->status = 'On Track';
        $release3_1->release_date = '2021-7-15';
        $release3_1->day_confirmed = false;
        $release3_1->description = 'Express replacement support.';
        $release3_1->project_id = 3;
        $release3_1->save();
    }
}