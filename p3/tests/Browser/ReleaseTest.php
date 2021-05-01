<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReleaseTest extends DuskTestCase
{
    use DatabaseMigrations;

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
                    ->click('@create-release-button')
                    ->assertVisible('@success-div')
                    ->assertSee('releaseTEST')
                    ->click('@release-releaseTEST')
                    ->assertVisible('@release-name-heading')
                    ->assertSee('releaseTEST');
        });
    }
}