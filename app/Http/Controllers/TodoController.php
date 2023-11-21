<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use App\Services\TodoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TodoController extends Controller
{
    private $tagService;
    private $todoService;

    public function __construct(TagService $tagService, TodoService $todoService)
    {
        $this->tagService = $tagService;
        $this->todoService = $todoService;
    }

    public function displayTodoListWithTags()
    {
        $selectedTodoId = request()->id;
        $allUserTags = $this->tagService->getUserTags();
        $tagsForSelectedTodo = $selectedTodoId ? $this->tagService->getTagsAssociatedWithTodo($selectedTodoId) : null;
        $tagsNotForSelectedTodo = $selectedTodoId ? $this->tagService->getTagsNotAssociatedWithTodo($selectedTodoId) : null;

        $isSortEnabled = session()->get('isSorted');
        $filteredTags = session()->get('selectedTags', []);

        $todos = $this->todoService->getTodoList($isSortEnabled);

        return View::make('TodoListMainPage', [
            'todos' => $todos,
            'isSorted' => $isSortEnabled,
            'openedId' => $selectedTodoId,
            'tags' => $tagsForSelectedTodo,
            'unselectedTags' => $tagsNotForSelectedTodo,
            'allTags' => $allUserTags,
            'filterTags' => $filteredTags,
        ]);
    }

    public function createTodo(Request $request)
    {
        if (! $request->title) {
            return redirect()->route('Main');
        }

        $user = auth()->user();
        if (! $user) {
            return $this->errorResponse('You need to log in to create a todo.', 'createError');
        }

        $this->todoService->createTodo(
            $request->title,
            $request->duedate,
            $user->id
        );

        return back();
    }

    public function toggleCompletedTodosVisibility()
    {
        $isSorted = session()->get('isSorted', false);

        $newSortOrder = ! $isSorted;

        session()->put('isSorted', $newSortOrder);

        return back();
    }

    public function toggleTodoCompletionStatus($id)
    {
        $this->todoService->toggleTodoCompletionStatus($id);

        return back();
    }

    public function updateTodo()
    {
        $request = request();
        $user = auth()->user();

        if (! $user) {
            return $this->errorResponse('You need to log in to update this todo.', 'createError');
        }

        $request['completed'] = $request->completed === 'on' ? true : false;
        $updateData = $request->except('_token');
        $updated = $this->todoService->updateTodo($request->id, $updateData, $user->id, $user->isAdmin());

        if (! $updated) {
            return $this->errorResponse('Failed to update the todo.', 'updateError');
        }

        return back();
    }

    public function deleteTodo($id)
    {
        $user = auth()->user();
        if (! $user) {
            return $this->errorResponse('You need to log in to delete this todo.', 'createError');
        }

        $deleted = $this->todoService->deleteTodo($id, $user->id, $user->isAdmin());

        if (! $deleted) {
            return $this->errorResponse('Failed to delete the todo.', 'deleteError');
        }

        return back();
    }

    private function errorResponse($message, $inputKey)
    {
        return back()->withErrors([
            $inputKey => $message,
        ])->onlyInput($inputKey);
    }
}
