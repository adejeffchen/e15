<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class ReleaseTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testReleaseEditButtonNotVisibleWhenNotLogin()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->visit('/releases/1')
                    ->assertVisible('@release-name-heading')
                    ->assertVisible('@release-status')
                    ->assertVisible('@release-date')
                    ->assertNotPresent('@edit-release-button');
        });
    }
    
    public function testReleaseCreateFailed()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('@login-email-input', 'jill@harvard.edu')
                    ->type('@login-password-input', 'asdfasdf')
                    ->click('@login-button')
                    ->click('@create-release-link')
                    ->assertVisible('@create-release-heading')
                    ->click('@create-release-button')
                    ->assertVisible('@release-name-error');
        });
    }

    public function testReleaseCreateSuccessAndDetail()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->click('@create-release-link')
                    ->select('projectId', '1')
                    ->type('@release-name-input', 'releaseTEST')
                    ->select('month', '12')
                    ->click('@create-release-button')
                    ->assertVisible('@success-div')
                    ->assertSee('releaseTEST')
                    ->click('@release-releaseTEST')
                    ->assertVisible('@release-name-heading')
                    ->assertSee('releaseTEST');
        });
    }

    public function testReleaseEditFail()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/releases/1')
                    ->click('@edit-release-button')
                    ->assertVisible('@edit-release-heading')
                    ->value('@release-name-input', '')
                    ->click('@edit-release-button')
                    ->assertVisible('@release-name-error');
        });
    }

    public function testReleaseEditSuccessful()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/releases/1')
                    ->click('@edit-release-button')
                    ->assertVisible('@edit-release-heading')
                    ->value('@release-name-input', 'Release Test')
                    ->radio('releaseStatus', 'At Risk')
                    ->select('month', '12')
                    ->value('@release-description-input', 'Release detail')
                    ->click('@edit-release-button')
                    ->assertSee('Release Test')
                    ->assertSee('At Risk')
                    ->assertSee('Dec')
                    ->assertSee('Release detail');
        });
    }

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
}