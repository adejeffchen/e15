<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class DependenciesTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testReleaseDependenciesView()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/releases/1')
                    ->assertVisible('@no-dependencies-div')
                    ->visit('/releases/3')
                    ->assertVisible('@dependencies-project-link')
                    ->assertVisible('@dependencies-release-link')
                    ->assertVisible('@dependencies-release-status');
        });
    }

    public function testReleaseDependenciesEditAddAndRemove()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/releases/2')
                    ->click('@edit-dependencies-button')
                    ->assertVisible('@edit-dependencies-heading')
                    ->check('dependencies[]')
                    ->click('@save-dependencies-button')
                    ->assertVisible('@dependencies-project-link')
                    ->assertVisible('@dependencies-release-link')
                    ->assertVisible('@dependencies-release-status')
                    ->click('@edit-dependencies-button')
                    ->uncheck('dependencies[]')
                    ->click('@save-dependencies-button')
                    ->assertVisible('@no-dependencies-div');
        });
    }
}