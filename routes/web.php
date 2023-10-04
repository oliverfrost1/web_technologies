<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todoController;

// Create instance of todoController
$todoController = new todoController();

Route::get('/', todoController::class . '@showTodoList')->name('forms');

Route::post("/SaveItem", todoController::class . '@store')->name("SaveItem");
Route::post("/changeCompletionStatus", todoController::class . '@changeCompletionStatus')->name("changeCompletionStatus");