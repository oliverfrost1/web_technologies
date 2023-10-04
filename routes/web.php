<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todoController;

// Create instance of todoController
$todoController = new todoController();

Route::get('/', todoController::class . '@showTodoList')->name('Main');
Route::get("/FilterTodos", todoController::class . '@changeSort')->name("FilterTodos");


Route::post("/SaveItem", todoController::class . '@store')->name("SaveItem");

Route::post("/changeCompletionStatus/{id}", [todoController::class, 'changeCompletionStatus'])->name("changeCompletionStatus");
Route::post("/deleteTodoElement/{id}", [todoController::class, 'deleteTodoElement'])->name("deleteTodoElement");

