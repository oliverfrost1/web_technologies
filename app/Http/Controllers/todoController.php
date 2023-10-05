<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Tag;
use App\Models\TodoTag;


use Illuminate\Support\Facades\View;

class todoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function showTodoList()
    {
        $isSorted = session()->get('isSorted');
        return View::make('TodoListMainPage', [
            "todos" => $isSorted ? $this->getTodo() : $this->getFilteredTodo(),
            "isSorted" => $isSorted,
            "openedId" => request()->id,
        ]);
    }

    public function changeSort(){
        $isSorted = session()->get('isSorted');
        $isSorted = $isSorted ? 0 : 1;
        session()->put('isSorted', $isSorted);
        return redirect()->route("Main");
    }

    //TMP----------------------------
    //Creates a new tag and associates it with the provided tag (should just call
    // attachTagToTodo)
    public function addNewTagToTodo(Request $request) {
        $tag = Tag::Create(["name" => $request->tagName]);
        return $this->attachTagToTodo($request);
    }
    //creates new association between an existing tag and a todo
    public function attachTagToTodo(Request $request){
        $todo = Todo::find( $request->todoid);
        $tag = Tag::find( $request->tagid);
        $todo->tags()->attach($tag);
        return redirect()->route("Main");
    }
    //Gets all tags associated with the provided todo id.
    public function getTagsAssociatedWithTodo(){
        $tags = Tag::whereHas('todos', function ($query) use ($todoId) {
            $query->where('todos.id', $todoId);
        })->get();
    }
    /**
     * Store a newly created todo in the database.
     */
    public function store(Request $request)
    {
        if(!$request->title){
            return redirect()->route("Main");
        }
        Todo::create([
            "title" => $request->title,
            "due_date" => $request->duedate,
        ]);
        return redirect()->route("Main");
    }

    /**
     * Display the specified resource.
     */
    public function getTodo()
    {
        // gets the enitre todolist from the database
        return Todo::all();
    }
    public function getFilteredTodo()
    {
        // gets the enitre todolist from the database
        return Todo::where('completed', 0)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    public function changeCompletionStatus($id)
    {
        # log the request
        \Log::info($id);
        $todo = Todo::find($id);
        \Log::info($todo);
        # TODO: Maybe change this.
        if ($todo->completed === 1) {
            $todo->completed = 0;
        } else {
            $todo->completed = 1;
        }
        $todo->save();
        return redirect()->route("Main");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteTodoElement($id)
    {
        # log the request
        \Log::info($id);
        $todo = Todo::find($id);
        $todo->delete();
        \Log::info($todo);
        return redirect()->route("Main");
    }
}
