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

    public function showTodoList()
    {
        $todoId = request()->id;
        $allTags = $this->tagService->getAllTagsOnUser();
        $tagsAssociatedWithSelectedTodo = $todoId ? $this->tagService->getTagsAssociatedWithTodo($todoId) : null;
        $tagsNotAssociatedWithSelectedTodo = $todoId ? $this->tagService->getTagsNotAssociatedWithTodo($todoId) : null;

        $isSorted = session()->get('isSorted');
        $filterTags = session()->get('selectedTags', []);

        $todos = $this->todoService->getTodoList($isSorted);

        return View::make('TodoListMainPage', [
            'todos' => $todos,
            'isSorted' => $isSorted,
            'openedId' => $todoId,
            'tags' => $tagsAssociatedWithSelectedTodo,
            'unselectedTags' => $tagsNotAssociatedWithSelectedTodo,
            'allTags' => $allTags,
            'filterTags' => $filterTags,
        ]);
    }

    public function changeSort()
    {
        $isSorted = session()->get('isSorted');
        $isSorted = $isSorted ? 0 : 1;
        session()->put('isSorted', $isSorted);

        return back();
    }

    public function changeSelectedTags(Request $request)
    {
        if (session()->has('selectedTags')) {
            $selectedTags = session()->get('selectedTags', []);
        } else {
            $selectedTags = [];
        }
        $curTag = $request->tag;
        $tagIndex = array_search($curTag, $selectedTags);
        if ($tagIndex !== false) {
            unset($selectedTags[$tagIndex]);
            $selectedTags = array_values($selectedTags);
        } elseif ($curTag) {
            $selectedTags[] = $curTag;
        }
        session()->put('selectedTags', $selectedTags);

        return back();
    }

    public function createTodo(Request $request)
    {
        if (! $request->title) {
            return redirect()->route('Main');
        }

        $user = auth()->user();
        if (! $user) {
            return back()->withErrors([
                'createError' => 'You need to log in to create a todo.',
            ])->onlyInput('createError');
        }

        $this->todoService->createTodo(
            $request->title,
            $request->duedate,
            $user->id
        );

        return back();
    }

    public function changeCompletionStatus($id)
    {
        $this->todoService->changeCompletionStatus($id);

        return back();
    }

    public function deleteTodo($id)
    {
        $user = auth()->user();
        if (! $user) {
            return back()->withErrors([
                'createError' => 'You need to log in to delete this todo.',
            ])->onlyInput('createError');
        }

        $deleted = $this->todoService->deleteTodo($id, $user->id, $user->isAdmin());

        if (! $deleted) {
            return back()->withErrors([
                'deleteError' => 'Failed to delete the todo.',
            ])->onlyInput('deleteError');
        }

        return back();
    }

    public function updateTodo()
    {
        $request = request();
        $user = auth()->user();

        if (! $user) {
            return back()->withErrors([
                'createError' => 'You need to log in to update this todo.',
            ])->onlyInput('createError');
        }

        $request['completed'] = $request->completed === 'on' ? true : false;
        $updateData = $request->except('_token');
        $updated = $this->todoService->updateTodo($request->id, $updateData, $user->id, $user->isAdmin());

        if (! $updated) {
            return back()->withErrors([
                'updateError' => 'Failed to update the todo.',
            ])->onlyInput('updateError');
        }

        return back();
    }

    public function createOrAttachTagToTodo(Request $request)
    {
        $user = auth()->user();
        $result = $this->tagService->createOrAttachTag($request->tagName, $user, $request->todoid);

        if (! $result) {
            return back()->withErrors([
                'createError' => 'You need to log in to add this tag to todo.',
            ])->onlyInput('createError');
        }

        return back();
    }

    public function detachTagFromTodo(Request $request)
    {
        $result = $this->tagService->detachTagFromTodo($request->tagid, $request->todoid);

        if (! $result) {
            return back()->withErrors([
                'removeError' => 'Failed to remove the tag from todo.',
            ])->onlyInput('removeError');
        }

        return back();
    }

    public function deleteTag(Request $request)
    {
        $selectedTags = $this->tagService->deleteTag($request->id, session()->get('selectedTags'));
        session()->put('selectedTags', $selectedTags);

        return back();
    }

    public function updateTag(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return back()->withErrors([
                'createError' => 'You need to log in to update this tag.',
            ])->onlyInput('createError');
        }

        $this->tagService->updateTag($request->tagId, $request->tagName, $user);

        return back();
    }
}
