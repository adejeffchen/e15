<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    public function testNavigationNotLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertVisible('@login-link')
                    ->assertNotPresent('@create-project-link')
                    ->assertNotPresent('@create-release-link');
        });
    }

    public function testCreateProjectRequireLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects/create')
                    ->assertVisible('@login-heading');
        });
    }

    public function testCreateReleaseRequireLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/releases/create')
                    ->assertVisible('@login-heading');
        });
    }
}