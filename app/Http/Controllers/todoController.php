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
    public function showTodoList($isSorted = 2)
    {
        if ($isSorted != 2) {
            $isSorted = $isSorted ? 0 : 1;
        }

        \Log::info(request());
        return View::make('TodoListMainPage', [
            "todos" => $isSorted ? $this->getTodo() : $this->getSortTodo(),
            "isSorted" => $isSorted,
            "openedId" => request()->id,
        ]);
    }

    /**
     * Store a newly created todo in the database.
     */
    public function store(Request $request)
    {

        Todo::create([
            "title" => $request->title,
            "due_date" => $request->duedate,
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
    public function getSortTodo()
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
        return redirect()->route("forms");
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
        return redirect()->route("forms");
    }
}