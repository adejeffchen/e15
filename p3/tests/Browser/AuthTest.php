<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    public function testLoginFailed()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('@login-link')
                    ->assertVisible('@login-heading')
                    ->click('@login-button')
                    ->assertVisible('@login-error-email')
                    ->assertVisible('@login-error-password');
        });
    }

    public function testLoginThenLogout()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('@login-email-input', 'jill@harvard.edu')
                    ->type('@login-password-input', 'asdfasdf')
                    ->click('@login-button')
                    ->assertVisible('@create-project-link')
                    ->assertVisible('@create-release-link')
                    ->click('@logout-link')
                    ->assertNotPresent('@create-project-link')
                    ->assertNotPresent('@create-release-link');
        });
    }

    public function testRegisterFailed()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->click('@register-link')
                    ->assertVisible('@register-heading')
                    ->click('@register-button')
                    ->assertVisible('@register-error-name')
                    ->assertVisible('@register-error-email')
                    ->assertVisible('@register-error-password');
        });
    }

    public function testRegisterSuccessful()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('@register-name-input', 'Jeff Chen')
                    ->type('@register-email-input', 'jchen@gmail.com')
                    ->type('@register-password-input', 'asdfasdf')
                    ->type('@register-password-confirm-input', 'asdfasdf')
                    ->click('@register-button')
                    ->assertVisible('@create-project-link')
                    ->assertVisible('@create-release-link');
        });
    }
}