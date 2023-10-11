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


    /**
     * Store a newly created todo in the database.
     */
    public function store(Request $request)
    {
        if(!$request->title){
            return redirect()->route("Main");
        }

        if (auth()->user()) {
            Todo::create([
                "title" => $request->title,
                "due_date" => $request->duedate,
                "user_id" => auth()->user()->id,
            ]);
            return redirect()->route("Main");
        }

        return back()->withErrors([
            'createError' => 'You need to log in to create a todo.',
        ])->onlyInput('createError');
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
