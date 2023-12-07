<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use app\Models\Todo;

class TodosTest extends TestCase
{

    public function test_hide_todo_hides_completed_todos(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    public function test_no_todo_visible_at_beginning(): void
    {
        $response = $this->get('/');
        Todo::make([
            'title' => 'TODO',
            'description',
            'completed',
            'user_id',
            'due_date',
            'created_at',
            'updated_at',
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
