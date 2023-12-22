<?php

namespace App\Services;

use App\Models\Todo;
use App\Services\Contracts\TodoService;

class TodoServiceImpl implements TodoService
{
    public function getTodoList($isSorted)
    {
        $todos = $this->getTodosBasedOnUserRole();

        $tags = session()->get('tagsForFiltering');
        if ($tags) {
            $todos = $this->filterTodosByTags($todos, $tags);
        }

        if ($isSorted) {
            $todos = $this->sortTodos($todos);
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
        $todo = $this->findTodoAndAuthorize($id, $userId, $isAdmin);
        if ($todo) {
            $todo->update($updateData);

            return true;
        }

        return false;
    }

    public function toggleTodoCompletionStatus($id)
    {
        $todo = $this->getTodoById($id);
        $todo->completed = ! $todo->completed;
        $todo->save();
    }

    public function deleteTodo($id, $userId, $isAdmin)
    {
        $todo = $this->findTodoAndAuthorize($id, $userId, $isAdmin);

        if ($todo) {
            $todo->delete();

            return true;
        }

        return false;
    }

    private function getTodosBasedOnUserRole()
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return Todo::join('users', 'todos.user_id', '=', 'users.id')
                ->select('todos.*', 'users.email as user_email')
                ->get();
        }

        return Todo::where('user_id', auth()->id())->get();
    }

    private function filterTodosByTags($todos, $tags)
    {
        return $todos->filter(function ($todo) use ($tags) {
            return $todo->tags->whereIn('id', $tags)->isNotEmpty();
        });
    }

    private function sortTodos($todos)
    {
        return $todos->filter(function ($todo) {
            return $todo->completed === 0;
        });
    }

    private function findTodoAndAuthorize($id, $userId, $isAdmin)
    {
        $todo = $this->getTodoById($id);
        if ($todo && ($todo->user_id === $userId || $isAdmin)) {
            return $todo;
        }

        return null;
    }

}
