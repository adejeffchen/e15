<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class ProjectTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testProjectDetailToReleaseDetail()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/1')
                    ->assertVisible('@project-name-heading')
                    ->click('@release-link')
                    ->assertVisible('@release-name-heading');
        });
    }

    public function testProjectEditFail()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/projects/1')
                    ->click('@edit-project-button')
                    ->assertVisible('@edit-project-heading')
                    ->value('@project-name-input', '')
                    ->value('@project-manager-input', '')
                    ->click('@edit-project-button')
                    ->assertVisible('@project-name-error')
                    ->assertVisible('@project-manager-error');
        });
    }

    public function testProjectEditSuccessful()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/projects/1')
                    ->click('@edit-project-button')
                    ->assertVisible('@edit-project-heading')
                    ->value('@project-name-input', 'Project Test')
                    ->value('@project-manager-input', 'Project Manager Test')
                    ->click('@edit-project-button')
                    ->assertSee('Project Test')
                    ->assertSee('Project Manager Test');
        });
    }

    public function testProjectCreateFailed()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/')
                    ->click('@create-project-link')
                    ->assertVisible('@create-project-heading')
                    ->click('@create-project-button')
                    ->assertVisible('@project-name-error')
                    ->assertVisible('@project-manager-error');
        });
    }

    public function testProjectCreateSuccessAndDetail()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->click('@create-project-link')
                    ->type('@project-name-input', 'ProjectJD')
                    ->type('@project-manager-input', 'John Doe')
                    ->click('@create-project-button')
                    ->assertVisible('@success-div')
                    ->assertSee('ProjectJD')
                    ->click('@project-ProjectJD')
                    ->assertVisible('@project-name-heading')
                    ->assertSee('ProjectJD')
                    ->assertSee('John Doe');
        });
    }

    public function testProjectPageAddReleaseButton()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/4')
                    ->click('@add-release-button')
                    ->assertVisible('@create-release-heading')
                    ->assertSelected('@project-select', 4);
        });
    }
}