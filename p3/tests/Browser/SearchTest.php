<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class SearchTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testSearchFromHomePageWhenNotLogin()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('@search-input', 'sky')
                    ->click('@search-button')
                    ->assertVisible('@search-results-heading')
                    ->assertVisible('@search-results-project-name')
                    ->assertSee('Skywalker')
                    ->assertVisible('@search-results-release-name')
                    ->click('@search-results-project-name')
                    ->assertVisible('@project-name-heading');
        });
    }

    public function testSearchFromSearchPage()
    {
        $this->seed();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/search')
                    ->assertVisible('@search-results-projects-empty-heading')
                    ->assertVisible('@search-results-releases-empty-heading')
                    ->type('@search-input', 'express')
                    ->click('@search-button')
                    ->assertVisible('@search-results-projects-empty-heading')
                    ->assertVisible('@search-results-release-name')
                    ->click('@search-results-release-name')
                    ->assertVisible('@release-name-heading');
        });
    }
}