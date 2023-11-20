<?php

namespace App\Services;

use App\Models\Todo;

class TodoService
{
    private $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function getTodoList($isSorted)
    {
        $userId = auth()->id();
        $tags = session()->get('selectedTags');

        if (auth()->check() && auth()->user()->isAdmin()) {
            $todos = Todo::join('users', 'todos.user_id', '=', 'users.id')
                ->select('todos.*', 'users.email as user_email')
                ->get();
        } else {
            $todos = Todo::where('user_id', $userId)->get();
        }

        if ($tags) {
            $todos = $this->getTodosAssociatedWithTag($tags);
        }

        if ($isSorted) {
            $todos = $todos->filter(function ($todo) {
                return $todo->completed === 0;
            });
        }

        return $todos;
    }

    public function changeCompletionStatus($id)
    {
        $todo = Todo::find($id);
        $todo->completed = ! $todo->completed;
        $todo->save();
    }

    private function getTodosAssociatedWithTag($tagIds)
    {
        $todos = Todo::whereHas('tags', function ($query) use ($tagIds) {
            $query->whereIn('tags.id', $tagIds);
        })->get();

        return $todos;
    }
}
