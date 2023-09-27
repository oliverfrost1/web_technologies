<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class todoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function markAsCompleted(Request $request, string $id)
    {
        $todo = Todo::find($id);
        $todo->completed = true;
        $todo->save();
        return redirect()->route("forms");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}