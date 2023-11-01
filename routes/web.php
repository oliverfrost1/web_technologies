<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

Route::get('/', todoController::class . '@showTodoList')->name('Main');
Route::get("/FilterTodos", todoController::class . '@changeSort')->name("FilterTodos");
Route::get('/Register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/Register', [RegisterController::class, 'register'])->name('register');
Route::get("/Login", AuthController::class . '@show')->name("Login");
Route::post('/Login', [AuthController::class, 'authenticate'])->name('Login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/Profile', function () { return view('Profile'); })->middleware('auth.basic')->name('profile');

Route::controller(AdminController::class)->middleware('admin')->group(function () {
    Route::get('/admin/dashboard', 'dashboard')->name('admin.dashboard');
    Route::get('/admin/editUser/{id}', 'editUserForm')->name('admin.edit-user');
    Route::post('/admin/editUser/{id}', 'editUser')->name('admin.edit-user');
    Route::get('/admin/deleteUser/{id}', 'deleteUser')->name('admin.delete-user');
});


Route::post('/addNewTag', todoController::class. '@addNewTagToTodo')->name("addNewTag");
Route::post('/attachTag', todoController::class. '@attachTagToTodo')->name("attachTag");
Route::post('/removeTagFromTodo', todoController::class. '@removeTagAssociation')->name("removeTagFromTodo");
Route::post('/removeTag', todoController::class. '@removeTag')->name("removeTag");
Route::post('/updateTag', todoController::class. '@updateTag')->name("updateTag");


Route::get("/filterByTags", todoController::class . '@changeSelectedTags')->name("filterByTags");


Route::post("/SaveItem", todoController::class . '@store')->name("SaveItem");

Route::post("/changeCompletionStatus/{id}", [todoController::class, 'changeCompletionStatus'])->name("changeCompletionStatus");
Route::post("/deleteTodoElement/{id}", [todoController::class, 'deleteTodoElement'])->name("deleteTodoElement");
Route::post("/updateTodoFields", [todoController::class, 'updateTodoFields'])->name("updateTodoFields");
