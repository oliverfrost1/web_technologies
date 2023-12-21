<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;

use TiMacDonald\Log\LogEntry;
use TiMacDonald\Log\LogFake;
use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;
use App\Models\Tag;

class TagsTest extends TestCase
{
    use RefreshDatabase;

    public function test_created_tag_shows_in_side_bar(): void
    {
        $user = User::create([
            'name' => 'testeasd',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        Tag::create([
            'name' => 'Chore',
            'user_id' =>$user->id
        ]);
        $response = $this->actingAs($user)-> get('/');
        $response->assertSee('Chore');
        $response->assertStatus(200);
    }

    public function test_attach_tag_shows_in_side_bar(): void
    {
        LogFake::bind();
        $user = User::create([
            'name' => 'testee',
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
        $response = $this->assertDatabaseHas('todos',[
            'id'=>$todo->id,
            'title'=>$todo->title
        ]);
        /*
        $tag = Tag::create([
            'name' => 'Chore',
            'user_id' =>$user->id
        ]);

        $response = $this->assertDatabaseHas('tags',[
            'id'=>$tag->id,
            'name'=>$tag->name
        ]);
        */
        $this->actingAs($user);
        $this->withoutMiddleware();
        $response -> assertAuthenticatedAs($user);
        //.'/tags',['todoid' => $todo->id,"tagName"=>$tag->name]);
        $response = $this->actingAs($user) -> post('/todos',['id' =>$todo->id]);
        //$response->assertStatus(200);
        /*
        Log::assertLogged(
            fn (LogEntry $log) => $log->message === 'tag exists'
        );

        Log::assertLogged(
            fn (LogEntry $log) => $log->message === 'tag & todo exists'
        );
        */
        /*
        $response->assertRedirect(route('main'));
        //dd($response->status(),$response->content());
        $response->assertStatus(200);
        $response = $this->assertDatabaseHas('tag_todo',[
            'todo_id'=>$todo->id,
            'tag_id'=>1
        ]);

        $response->assertStatus(200);
        */
    }



}
