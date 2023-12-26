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
    //would likely benefit from setup/teardown

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
    public function test_filter_tag_with_session(): void
    {
        $user = User::create([
            'name' => 'testeasd',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $tag = Tag::create([
            'name' => 'Chore',
            'user_id' =>$user->id
        ]);
        $todo = Todo::create([
            'title' => 'Homework',
            'description' => null,
            'completed' => false,
            'user_id' => $user->id,
            'due_date' => null
        ]);
        $todo2 = Todo::create([
            'title' => 'Play',
            'description' => null,
            'completed' => false,
            'user_id' => $user->id,
            'due_date' => null
        ]);
        $todo->tags()->attach($tag);
        $response = $this->actingAs($user)-> get('/');
        $response->assertSee('Homework');
        $response->assertSee('Play');
        $response = $this->actingAs($user)->withSession(['selectedTags'=>[$tag->id]])-> get('/');
        $response->assertStatus(200);
        $response->assertSee('Homework');
        $response->assertDontSee('Play');

    }

    public function test_delete_attached_tag_removes_attachment(): void{
        $user = User::create([
            'name' => 'testeasd',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $tag = Tag::create([
            'name' => 'Chore',
            'user_id' =>$user->id
        ]);
        $todo = Todo::create([
            'title' => 'Homework',
            'description' => null,
            'completed' => false,
            'user_id' => $user->id,
            'due_date' => null
        ]);
        $todo->tags()->attach($tag);
        $this->assertDatabaseHas('tag_todo',[
            'tag_id' => $tag->id,
            'todo_id'=>$todo->id
        ]);
        $response = $this->actingAs($user)->followingRedirects()-> delete('/tags/'.$tag->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('tag_todo',[
            'tag_id' => $tag->id,
            'todo_id'=>$todo->id
        ]);
    }

    public function test_update_tag_in_sidebar(): void{
        $user = User::create([
            'name' => 'testeasd',
            'email' => 'test@test.com',
            'password' => '12345678'
        ]);
        $tag = Tag::create([
            'name' => 'Chore',
            'user_id' =>$user->id
        ]);
        $this->assertDatabaseHas('tags',[
            'id' => $tag->id,
            'name' => $tag->name
        ]);
        $response = $this->actingAs($user)->followingRedirects()-> put('/tags/'.$tag->id, ['tagId'=>$tag->id,'tagName'=>'Fun']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tags',[
            'id' => $tag->id,
            'name' => 'Fun'
        ]);
        $this->assertDatabaseMissing('tags',[
            'id' => $tag->id,
            'name' => $tag->name
        ]);
    }


    public function test_attach_tag_from_sidebar(): void
    {
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
        $tag = Tag::create([
            'name' => 'Chore',
            'user_id' =>$user->id
        ]);
        $this->assertDatabaseMissing('tag_todo',[
            'tag_id' => $tag->id,
            'todo_id'=>$todo->id
        ]);
        $response = $this->actingAs($user) -> followingRedirects() -> post('/todos/'.$todo->id.'/tags',['tagName'=>$tag->name,'todoid'=>$todo->id]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('tag_todo',[
            'tag_id' => $tag->id,
            'todo_id'=>$todo->id
        ]);
    }



}
