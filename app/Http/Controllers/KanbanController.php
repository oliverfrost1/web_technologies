<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function showKanban()
    {
        return view('KanbanBoard');
    }

    public function logSomething() {
        Log::info("Something");
    }
}
