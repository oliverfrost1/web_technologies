<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Todo;
use App\Models\User;

class TodoTest extends DuskTestCase
{
    public function test_checkbox_hide_completed(): void
    {
        $this->browse(function (Browser $browser){
            $browser->visit('/auth/register')
                ->type('name','testeee')
                ->type('email','ttt@test.com')
                ->type('password','12345678')
                ->type('#password-confirm','12345678')
                ->press('#submit');
        });
        $this->browse(function (Browser $browser) {
            $browser
            ->visit('/')
            ->type('title','Play')
            ->press('#plus-icon-add-todo')
            ->check('#changeCompletionStatus-1')
            ->pause(500)
            ->press('#hide-completed')
            ->pause(500)
            ->assertDontSee('Play')
            ->press('#hide-completed')
            ->pause(500)
            ->assertSee('Play');
        });
    }

}
