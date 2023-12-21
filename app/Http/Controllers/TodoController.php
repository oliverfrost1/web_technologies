<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TodoController extends Controller
{
    public function showTodoList()
    {
        $todoId = request()->id;
        $tagsOnSelectedTodo = null;
        $allTags = $this->getAllTagsOnUser();
        $unselectedTagsOnTodo = null;
        if ($todoId) {
            //Main page has been loaded with a todo selected
            $tagsOnSelectedTodo = $this->getTagsAssociatedWithTodo($todoId);
            $unselectedTagsOnTodo = $this->getTagsNotAssociatedWithTodo($todoId);
        }
        $isSorted = session()->get('isSorted');
        $filterTags = session()->get('selectedTags');
        if (! $filterTags) {
            $filterTags = [];
        }

        return View::make('TodoListMainPage', [
            'todos' => $this->getTodo($isSorted),
            'isSorted' => $isSorted,
            'openedId' => $todoId,
            'tags' => $tagsOnSelectedTodo,
            'unselectedTags' => $unselectedTagsOnTodo,
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
        if (!$request->title) {
            return redirect()->route('main');
        }

        if (auth()->user()) {
            Todo::create([
                'title' => $request->title,
                'due_date' => $request->duedate,
                'user_id' => auth()->user()->id,
            ]);

            return back();
        }

        return back()->withErrors([
            'createError' => 'You need to log in to create a todo.',
        ])->onlyInput('createError');
    }

    public function getTodo($isSorted)
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
        // gets the entire todolist from the database
        if ($isSorted) {
            $todos = $todos->filter(function ($todo) {
                return $todo->completed === 0;
            });
        }

        return $todos;
    }

    public function changeCompletionStatus($id)
    {
        // log the request
        $todo = Todo::find($id);
        if ($todo->completed === 1) {
            $todo->completed = 0;
        } else {
            $todo->completed = 1;
        }
        $todo->save();

        return back();
    }

    public function deleteTodoElement($id)
    {
        $user = auth()->user();
        if ($user || $user->isAdmin()) {
            $todo = Todo::find($id);
            if ($todo->user_id === $user->id || $user->isAdmin()) {
                $todo->delete();

                return back();
            }
        }

        return back()->withErrors([
            'createError' => 'You need to log in to delete this todo.',
        ])->onlyInput('createError');

    }

    public function updateTodoFields()
    {
        $request = request();
        $user = auth()->user();
        if ($user) {
            $todo = Todo::find($request->id);
            if ($todo && ($todo->user_id === $user->id || $user->isAdmin())) {
                $request['completed'] = $request->completed === 'on' ? true : false;
                $updateData = $request->except('_token');
                $todo->update($updateData);

                return back();
            }
        }

        return back()->withErrors([
            'createError' => 'You need to log in to update this todo.',
        ])->onlyInput('createError');
    }

    public function getAllTagsOnUser()
    {
        $user = auth()->user();
        $tags = [];
        if ($user) {
            if ($user->isAdmin()) {
                $tags = Tag::all();
            } else {
                $tags = Tag::where('user_id', $user->id)->get();
            }
        }

        return $tags;
    }

    public function addNewTagToTodo(Request $request)
    {
        if (! $request->tagName) {
            return back();
        }
        $tag = $this->getTagFromName($request->tagName);
        $user = auth()->user();

        if ($user->isAdmin()) {

            return back();
        }
        if ($tag) {
            \Log::info("tag exists");

            $tagid = $tag->id;
            $request->merge(['tagid' => $tagid]);

            return $this->attachTagToTodo($request);
        }
        if ($user) {
            \Log::info("Tag not exist");
            $tag = Tag::Create(['name' => $request->tagName, 'user_id' => $user->id]);
            $tagid = $tag->id;
            $request->merge(['tagid' => $tagid]);

            return $this->attachTagToTodo($request);
        } else {
            return back()->withErrors([
                'createError' => 'You need to log in to add this tag to todo.',
            ])->onlyInput('createError');
        }
    }

    //creates new association between an existing tag and a todo
    public function attachTagToTodo(Request $request)
    {
        try{
            $todo = Todo::find($request->todoid);
            $tag = Tag::find($request->tagid);

            if ($todo && $tag) {
                \Log::info("tag & todo exists");
                $todo->tags()->attach($tag);
            }
        } catch(\Exception $e){
            \Log::info("test");
            \Log::error("Error attaching tag to todo: " .$e->getMessage());
        }
        return back();
    }

    public function removeTagAssociation(Request $request)
    {
        $tagId = $request->tagid;
        $todo = Todo::find($request->todoid);
        $todo->tags()->detach($tagId);

        return back();
    }

    public function removeTag(Request $request)
    {
        $tagId = $request->id;
        $selectedTags = session()->get('selectedTags');
        $tagIndex = array_search($tagId, (array) $selectedTags);
        if ($tagIndex !== false) {
            unset($selectedTags[$tagIndex]);
            $selectedTags = array_values($selectedTags);
        }
        session()->put('selectedTags', $selectedTags);
        Tag::destroy($tagId);

        return back();
    }

    public function getTagsAssociatedWithTodo($todoId)
    {
        $tags = Tag::whereHas('todos', function ($query) use ($todoId) {
            $query->where('todos.id', $todoId);
        })->get();

        return $tags;
    }

    public function updateTag(Request $request)
    {
        $tagId = $request->tagId;
        $tagName = $request->tagName;
        $user = auth()->user();
        if ($user) {
            $tag = Tag::find($tagId);
            if ($tag && ($tag->user_id === $user->id || $user->isAdmin())) {
                $tag->name = $tagName;
                $tag->save();

                return back();
            }
        }

        return back()->withErrors([
            'createError' => 'You need to log in to update this tag.',
        ])->onlyInput('createError');

        return $tag;
    }

    private function getTodosAssociatedWithTag($tagIds)
    {
        $todos = Todo::whereHas('tags', function ($query) use ($tagIds) {
            $query->whereIn('tags.id', $tagIds);
        })->get();

        return $todos;
    }

    private function getTagsNotAssociatedWithTodo($todoId)
    {
        $tags = $this->getTagsAssociatedWithTodo($todoId);
        $tag_ids = $tags->pluck('id')->toArray();
        $user = auth()->user();
        $unselectedTags = [];
        if ($user) {
            if ($user->isAdmin()) {
                $unselectedTags = Tag::whereNotIn('id', $tag_ids)->get();
            } else {
                $unselectedTags = Tag::where('user_id', $user->id)->whereNotIn('id', $tag_ids)->get();
            }
        }

        return $unselectedTags;
    }

    private function getTagFromName($tagName)
    {
        $tag = Tag::where('name', $tagName)->first();

        return $tag;
    }
}
