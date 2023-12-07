<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class KanbanController extends Controller
{
    public function showKanban()
    {
        return view('KanbanBoard');
    }

    public function updateTodo($id)
    {
        $newStatus = request()->status;
        $todo = Todo::find($id);
        if(!$todo) {
            return response()->json([
                'message' => 'Todo not found'
            ], 404);
        }

        $todo->update([
            'status' => $newStatus
        ]);

        // Also update completed status
        if(
            $newStatus === 'todo'
        ) {
            $todo->update([
                'completed' => 0
            ]);
        } elseif (
            $newStatus === 'done'
        ) {
            $todo->update([
                'completed' => 1
            ]);

        }

        $result = $todo->save();

        if(!$result) {
            return response()->json([
                'message' => 'Todo update failed'
            ], 500);
        }
        return response()->json([
            'message' => 'Todo updated successfully'
        ], 200);
    }
}
