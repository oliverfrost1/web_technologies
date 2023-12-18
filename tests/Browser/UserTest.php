<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;


class UserTest extends DuskTestCase
{
    protected $connectionsToTransact = ['dusk_testing'];

    use DatabaseMigrations; // does not seem to work, remember to run manual fresh migration of database
    //might work on laptop, as in it rolls back between tests, but it doesnt do a fresh migration
    /*
    * @test
    * Tests if the user is capable of registering a new account
    */
    public function testRegister(): void
    {
        $delay = 0;
        $this->browse(function (Browser $browser) use ($delay){
            $browser->visit('/auth/register')
                ->type('name','tester')
                ->pause($delay)
                ->type('email','testing@test.com')
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
    public function test_add_todo_without_logging_in(): void
    {
        $delay = 0;
        $this->browse(function (Browser $browser) use ($delay){
            $browser->visit('/')
                ->press('#logout-button')
                ->type('title','work')
                ->press('#plus-icon-add-todo')
                ->assertSee('You need to log in to create a todo.')
                ->assertDontSee('work');
        });

    }
    /*
    * @test
    * Tests if the user is capable of registering a new account with an existing email
    */
    public function testRegisterExistingEmail(): void
    {
        $user = User::create([
            'email' => 'test@test.com',
            'name' => 'tester',
            'password' => '12345678'
        ]);
        $delay = 0;
        $this->browse(function (Browser $browser) use ($delay){
            $browser->visit('/auth/register')
                ->type('name','tester')
                ->type('email','test@test.com')
                ->type('password','12345678')
                ->type('#password-confirm','12345678')
                ->press('#submit')
                ->visit('/auth/register')
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
        $user = User::create([
            'email' => 'test@test.com',
            'name' => 'tester',
            'password' => '12345678'
        ]);
        $delay = 0;
        $this->browse(function (Browser $browser) use ($delay, $user){
            $browser->visit('/auth/login')
                ->type('email',$user->email)
                ->pause($delay)
                ->type('password',12345678)
                ->pause($delay)
                ->press('Login')
                ->pause($delay)
                ->assertDontSee('The provided credentials do not match our records')
                ->assertSee('tester');
        });
    }
    /*
    * @test
    * Tests if the user is capable of loggin in without an existing account
    */
    public function testLoginWithoutAccount(): void
    {
        $delay = 0;
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
