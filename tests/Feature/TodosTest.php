<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;
class TodosTest extends TestCase
{
    use RefreshDatabase;
    public function test_shows_todo(): void
    {
        $user = User::create([
            'name' => 'tester',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $todo = ["title" => "todo"];
        $response = $this->actingAs($user)-> post('todos',$todo);
        $response = $this->get('/');
        $response->assertSee('.todo-element');
        $response->assertStatus(200);
    }
    public function test_no_todo_visible_at_beginning(): void
    {
        $response = $this->get('/');
        $user = User::create([
            'name' => 'tester',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        Todo::create([
            'title' => 'TODO',
            'description' => null,
            'completed' => false,
            'user_id' => $user->id,
            'due_date' => null
        ]);
        $response->assertDontSee('.todo-element');
        $response->assertStatus(200);
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
