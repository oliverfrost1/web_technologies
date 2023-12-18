<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Todo;
use App\Models\User;
use App\Models\Tag;

class TagBrowserTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_tag_is_displayed_in_datalist(): void
    {
        $this->browse(function (Browser $browser){
            $browser->visit('/auth/register')
                ->type('name','tester')
                ->type('email','tesasdt@test.com')
                ->type('password','12345678')
                ->type('#password-confirm','12345678')
                ->press('#submit');
        });
        $this->browse(function (Browser $browser) {
            $browser
            ->visit('/')
            ->type('title','work')
            ->press('#plus-icon-add-todo')
            ->press('#openSelectedWindow-1')
            ->waitFor('#add-tag-form')
            ->pause(5000)
            ->type('tagName','grind')
            ->pause(500)
            ->keys('tagName','{enter}')
            ->pause(500);


            //check if datalist contains "grind" when editing a new todo

        });
    }
}
