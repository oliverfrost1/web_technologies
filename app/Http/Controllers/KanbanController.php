<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function showKanban()
    {
        return view('KanbanBoard');
    }

    public function updateTodo()
    {
        \Log::info('Updating todo', ['request' => request()->all()]);
        return response()->json([
            'message' => 'Todo updated successfully'
        ]);
    }
}
