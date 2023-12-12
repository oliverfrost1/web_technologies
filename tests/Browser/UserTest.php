<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserTest extends DuskTestCase
{
    use DatabaseMigrations; // does not seem to work, remember to run manual fresh migration of database
    /*
    * @test
    * Tests if the user is capable of registering a new account
    */
    public function testRegister(): void
    {
        $delay = 1000;
        $this->browse(function (Browser $browser) use ($delay){
            $browser->visit('/auth/register')
                ->type('name','tester')
                ->pause($delay)
                ->type('email','test@test.com')
                ->pause($delay)
                ->type('password','12345678')
                ->pause($delay)
                ->type('#password-confirm','12345678')
                ->pause($delay)
                ->press('#submit')
                ->pause($delay)
                ->assertDontSee('The email has already been taken');
        });
    }
    /*
    * @test
    * Tests if the user is capable of registering a new account with an existing email
    */
    public function testRegisterExistingEmail(): void
    {
        $delay = 1000;
        $this->browse(function (Browser $browser) use ($delay){
            $browser->visit('/auth/register')
                ->type('name','tester')
                ->pause($delay)
                ->type('email','test@test.com')
                ->pause($delay)
                ->type('password','12345678')
                ->pause($delay)
                ->type('#password-confirm','12345678')
                ->pause($delay)
                ->press('#submit')
                ->pause($delay)
                ->assertSee('The email has already been taken');
        });
    }
    /*
    * @test
    * Tests if the user is capable of loggin in with an existing account
    */
    public function testLogin(): void
    {
        $delay = 1000;
        $this->browse(function (Browser $browser) use ($delay){
            $browser->visit('/auth/login')
                ->type('email','test@test.com')
                ->pause($delay)
                ->type('password','12345678')
                ->pause($delay)
                ->press('Login')
                ->pause($delay)
                ->assertDontSee('The provided credentials do not match our records');
        });
    }
    /*
    * @test
    * Tests if the user is capable of loggin in without an existing account
    */
    public function testLoginWithoutAccount(): void
    {
        $delay = 1000;
        $this->browse(function (Browser $browser) use ($delay){
            $browser->visit('/auth/login')
                ->type('email','nottest@test.com')
                ->pause($delay)
                ->type('password','66645678')
                ->pause($delay)
                ->press('Login')
                ->pause($delay)
                ->assertSee('The provided credentials do not match our records');
        });
    }
}
