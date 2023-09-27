<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoElement;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info(json_encode($request->all()));
        return redirect()->route("forms");
    }

    /**
     * Display the specified resource.
     */
    public function getTodo()
    {
        // gets the enitre todolist from the database


        // Create dummy todo
        $todoList = [new TodoElement("testing", "id", false)];
        array_push($todoList, new TodoElement("testing2", "id2", false));
        array_push($todoList, new TodoElement("testing3", "id3", false));
        array_push($todoList, new TodoElement("testing4", "id4", false));
        return $todoList;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}