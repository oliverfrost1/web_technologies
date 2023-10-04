<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\View;

class todoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showTodoList()
    {
        return View::make('TodoListMainPage')->with("todos", $this->getTodo());
    }

    /**
     * Store a newly created todo in the database.
     */
    public function store(Request $request)
    {
        Todo::create([
            "title" => $request->title,
        ]);
        return redirect()->route("forms");
    }

    /**
     * Display the specified resource.
     */
    public function getTodo()
    {
        // gets the enitre todolist from the database
        return Todo::all();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    public function changeCompletionStatus(Request $request)
    {
        # log the request
        \Log::info($request);
        $todo = Todo::find($request->todo_id);
        \Log::info($todo);
        # TODO: Maybe change this.
        if ($todo->completed === 1) {
            $todo->completed = 0;
        } else {
            $todo->completed = 1;
        }
        $todo->save();
        return redirect()->route("forms");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteTodoElement(Request $request)
    {
        # log the request
        \Log::info($request);
        $todo = Todo::find($request->todo_id);
        $todo->delete();
        \Log::info($todo);
        return redirect()->route("forms");
    }
}