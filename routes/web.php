<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todoController;

// Create instance of todoController
$todoController = new todoController();

Route::get('/', function () use ($todoController) {
    return View::make('TodoListMainPage')->with("todos", $todoController->getTodo());
})->name('forms');

Route::post("/SaveItem", todoController::class . '@store')->name("SaveItem");
Route::post("/changeCompletionStatus", todoController::class . '@changeCompletionStatus')->name("changeCompletionStatus");