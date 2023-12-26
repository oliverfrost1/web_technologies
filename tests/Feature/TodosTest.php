<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;
class TodosTest extends TestCase
{
    use RefreshDatabase;

    public function test_created_todo_is_shown_on_main_page(): void
    {
        $user = User::create([
            'name' => 'tester',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $todo = ['title' => 'homework'];
        $response = $this->actingAs($user)-> post('/todos',$todo);
        $this->assertDatabaseHas('todos',[
            'title' => 'homework',
        ]);
        $response = $this->get('/');
        $response->assertSee('todo-element');
        $response->assertSee('homework');

        $response->assertStatus(200);
    }
    public function test_no_todo_visible_at_beginning(): void
    {
        $user = User::create([
            'name' => 'tester',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $response = $this->actingAs($user)-> get('/');

        $response->assertDontSee('todo-element ');
        Todo::create([
            'title' => 'Homework',
            'description' => null,
            'completed' => false,
            'user_id' => $user->id,
            'due_date' => null
        ]);
        $response = $this->actingAs($user)-> get('/');
        $response->assertSee('todo-element ');
        $response->assertSee('Homework');
        $response->assertStatus(200);
    }

    public function test_dont_see_todo_from_other_users(): void
    {
        $user = User::create([
            'name' => 'tester',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $notUser = User::create([
            'name' => 'testee',
            'email' => 'nottest@test.com',
            'password' => '12345678'
        ]);
        Todo::create([
            'title' => 'Homework',
            'description' => null,
            'completed' => false,
            'user_id' => $user->id,
            'due_date' => null
        ]);
        $response = $this->actingAs($notUser)-> get('/');
        $response->assertStatus(200);
        $response->assertDontSee('Homework');
    }
    public function test_edit_todo_from_sidebar(): void
    {
        $user = User::create([
            'name' => 'tester',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $todo = Todo::create([
            'title' => 'Homework',
            'description' => null,
            'completed' => false,
            'user_id' => $user->id,
            'due_date' => null
        ]);
        $this->assertDatabaseHas('todos',[
            'id' => $todo->id,
            'completed'=>false
        ]);

        $response = $this->actingAs($user)-> followingRedirects()-> put('/todos/'.$todo->id,['id'=>$todo->id,'completed'=>'on']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('todos',[
            'id' => $todo->id,
            'completed'=>true
        ]);
    }
    public function test_delete_todo(): void
    {
        $user = User::create([
            'name' => 'tester',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $todo = Todo::create([
            'title' => 'Homework',
            'description' => null,
            'completed' => false,
            'user_id' => $user->id,
            'due_date' => null
        ]);
        $this->assertDatabaseHas('todos',[
            'id' => $todo->id,
        ]);
        $response = $this->actingAs($user)-> followingRedirects()-> delete('/todos/'.$todo->id,['id'=>$todo->id,'completed'=>'on']);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('todos',[
            'id' => $todo->id,
        ]);
    }

    public function smoke_test():void{
        $response = $this->get('/profile');
        $response->assertStatus(200);
        $response = $this->get('/');
        $response->assertStatus(200);
        $response = $this->get('/todos');
        $response->assertStatus(200);
        $response = $this->get('/tags/filter');
        $response->assertStatus(200);
    }
}
