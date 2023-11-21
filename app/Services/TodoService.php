<?php

namespace App\Services;

use App\Models\Todo;

class TodoService
{
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

    public function getTodoById($id)
    {
        return Todo::find($id);
    }

    public function createTodo($title, $dueDate, $userId)
    {
        return Todo::create([
            'title' => $title,
            'due_date' => $dueDate,
            'user_id' => $userId,
        ]);
    }

    public function updateTodo($id, $updateData, $userId, $isAdmin)
    {
        $todo = Todo::find($id);
        if ($todo && ($todo->user_id === $userId || $isAdmin)) {
            $todo->update($updateData);

            return true;
        }

        return false;
    }

    public function toggleTodoCompletionStatus($id)
    {
        $todo = Todo::find($id);
        $todo->completed = ! $todo->completed;
        $todo->save();
    }

    public function deleteTodo($id, $userId, $isAdmin)
    {
        $todo = Todo::find($id);
        if ($todo && ($todo->user_id === $userId || $isAdmin)) {
            $todo->delete();

            return true;
        }

        return false;
    }

    private function getTodosAssociatedWithTag($tagIds)
    {
        $todos = Todo::whereHas('tags', function ($query) use ($tagIds) {
            $query->whereIn('tags.id', $tagIds);
        })->get();

        return $todos;
    }
}
