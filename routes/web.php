<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todoController;

// Create instance of todoController
$todoController = new todoController();

Route::get('/', todoController::class . '@showTodoList')->name('Main');
Route::get("/FilterTodos", todoController::class . '@changeSort')->name("FilterTodos");

Route::post('/addNewTag', todoController::class. '@addNewTagToTodo')->name("addNewTag");
Route::post('/attachTag', todoController::class. '@attachTagToTodo')->name("attachTag");
Route::post('/removeTag', todoController::class. '@removeTagAssociation')->name("removeTag");


Route::post("/SaveItem", todoController::class . '@store')->name("SaveItem");

Route::post("/changeCompletionStatus/{id}", [todoController::class, 'changeCompletionStatus'])->name("changeCompletionStatus");
Route::post("/deleteTodoElement/{id}", [todoController::class, 'deleteTodoElement'])->name("deleteTodoElement");

