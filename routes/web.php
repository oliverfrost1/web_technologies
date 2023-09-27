<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todoController;

// Create instance of todoController
$todoController = new todoController();

Route::get('/', function () use ($todoController) {
    return view('TodoListMainPage', ["todos" => $todoController->getTodo()]);
})->name('forms');

Route::post("/SaveItem", function () use ($todoController) {
    return $todoController->store(request());
})->name("SaveItem");