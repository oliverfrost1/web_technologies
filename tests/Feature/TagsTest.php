<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            'name' => 'tester',
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
        $tag = Tag::create([
            'name' => 'Chore',
            'user_id' =>$user->id
        ]);
        $response = $this->actingAs($user) -> post('todos/'.$todo->id.'/tags',["tagName"=>$tag->id]);
        $response = $this->actingAs($user)-> get('/', [ "id" => $todo->id]);

        $response->assertSee('#sidebar-holder');
        $response->assertSee('Chore');
        $response->assertSee('tag-holder');

        $response->assertStatus(200);
    }

}
