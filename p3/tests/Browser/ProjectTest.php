<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProjectTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testProjectCreateFailed()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('@login-email-input', 'jill@harvard.edu')
                    ->type('@login-password-input', 'asdfasdf')
                    ->click('@login-button')
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
}