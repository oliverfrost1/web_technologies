<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todoController;

// Create instance of todoController
$todoController = new todoController();

Route::get('/', todoController::class . '@showTodoList')->name('Main');
Route::get("/FilterTodos", todoController::class . '@changeSort')->name("FilterTodos");
Route::get('/Register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/Register', [RegisterController::class, 'register'])->name('register');
Route::get("/Login", AuthController::class . '@show')->name("Login");
Route::post('/Login', [AuthController::class, 'authenticate'])->name('Login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/Profile', function () {
    // Only authenticated users may access this route.
    return view('Profile');
})->middleware('auth.basic')->name('profile');

Route::post('/addNewTag', todoController::class. '@addNewTagToTodo')->name("addNewTag");
Route::post('/attachTag', todoController::class. '@attachTagToTodo')->name("attachTag");
Route::post('/removeTagFromTodo', todoController::class. '@removeTagAssociation')->name("removeTagFromTodo");
Route::post('/removeTag', todoController::class. '@removeTag')->name("removeTag");

Route::get("/filterByTags", todoController::class . '@changeSelectedTags')->name("filterByTags");


Route::post("/SaveItem", todoController::class . '@store')->name("SaveItem");

Route::post("/changeCompletionStatus/{id}", [todoController::class, 'changeCompletionStatus'])->name("changeCompletionStatus");
Route::post("/deleteTodoElement/{id}", [todoController::class, 'deleteTodoElement'])->name("deleteTodoElement");
Route::post("/updateTodoFields", [todoController::class, 'updateTodoFields'])->name("updateTodoFields");
