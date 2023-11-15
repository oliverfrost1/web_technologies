<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function showKanban()
    {
        return view('KanbanBoard');
    }

    public function test() {
        return response()->json([
            'success' => true,
            'message' => 'You have successfully tested something.'
        ], 200);
    }
}
