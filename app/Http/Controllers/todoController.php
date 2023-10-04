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
    public function addTag() {
        Tag::Create(["name" => "test"]);
        return redirect()->route("Main");
    }
    public function addTodoTag(Request $request){
        Tag::Create(["name" => "test"]);

        $todo = Todo::find( $request->todoid);
        $tags = Tag::find( $request->tagid);
        $todo->tags()->attach($tags);
        return redirect()->route("Main");
    }
    /*
    public function getTagsAssociatedWithTodo(){
        $tags = Tag::whereHas('todos', function ($query) use ($todoId) {
            $query->where('todos.id', $todoId);
        })->get();


    }
*/
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
