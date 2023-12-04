<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\KanbanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class , 'showTodoList'])->name('main');
Route::get('filter-todos', [TodoController::class , 'changeSort'])->name('filter-todos');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('login', [AuthController::class , 'show'])->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('profile', [ProfileController::class, 'getProfilePage'])->middleware('auth.basic')->name('profile');

Route::controller(AdminController::class)->middleware('admin')->group(function () {
    Route::get('admin/dashboard', 'dashboard')->name('admin.dashboard');
    Route::get('admin/editUser/{id}', 'editUserForm')->name('admin.edit-user');
    Route::put('admin/editUser/{id}', 'editUser')->name('admin.edit-user');
    Route::delete('admin/deleteUser/{id}', 'deleteUser')->name('admin.delete-user');
});

Route::post('tag/add', [TodoController::class , 'addNewTagToTodo'])->name('addNewTag');
Route::post('tag/attach', [TodoController::class , 'attachTagToTodo'])->name('attachTag');
Route::delete('tag/remove/todo', [TodoController::class , 'removeTagAssociation'])->name('removeTagFromTodo');
Route::delete('tag/remove', [TodoController::class , 'removeTag'])->name('removeTag');
Route::put('tag/update', [TodoController::class , 'updateTag'])->name('updateTag');

Route::get('tags/filter', [TodoController::class , 'changeSelectedTags'])->name('filterByTags');

Route::post('todo/save', [TodoController::class , 'createTodo'])->name('SaveItem');

Route::put('completion-status/{id}', [TodoController::class, 'changeCompletionStatus'])->name('changeCompletionStatus');
Route::delete('todo/delete/{id}', [TodoController::class, 'deleteTodoElement'])->name('deleteTodoElement');
Route::put('todo/update', [TodoController::class, 'updateTodoFields'])->name('updateTodoFields');

// Kanban board routes
Route::get('kanban', KanbanController::class . '@showKanban')->name('kanban');
Route::post("logSomething", KanbanController::class . '@logSomething')->name("logSomething");
Route::post("/logSomething", KanbanController::class . '@logSomething');
