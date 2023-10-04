<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoTag extends Model
{
    use HasFactory;
    
    public function todos(){
        return $this -> belongsToMany(Todo::class,'todo_tags');
    }
    public function tags() {
        return $this -> belongsToMany(Todo::class,'todo_tags');
    }
}

/*
$todoTags = TodoTags::join('todos','todo_tags.todo_id','todos.id')
    -> join('tags','todo_tags.tag_id', 'tags.id')
    ->select('todo_tags.id','tags.id','todos.id')->get();
*/
