<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Release;

class DependentReleaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addDependentReleases();
    }

    private function addDependentReleases()
    {
        $release1 = Release::where('id', '=', '1')->first();
        $release2 = Release::where('id', '=', '2')->first();
        $release3 = Release::where('id', '=', '3')->first();
        $release4 = Release::where('id', '=', '4')->first();
        $release5 = Release::where('id', '=', '5')->first();

        $release3->dependencies()->save($release1, [
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),]);
        $release3->dependencies()->save($release2, [
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),]);
        $release3->dependencies()->save($release5, [
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),]);
        $release5->dependencies()->save($release1, [
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),]);
    }
}