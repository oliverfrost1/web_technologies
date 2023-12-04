<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('login', [AuthController::class , 'show'])->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes
Route::get('profile', [ProfileController::class, 'getProfilePage'])->middleware('auth.basic')->name('profile');
Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');

// Admin routes
Route::middleware('admin')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/editUser/{id}', [AdminController::class, 'editUserForm'])->name('admin.edit-user');
    Route::put('admin/editUser/{id}', [AdminController::class, 'editUser'])->name('admin.edit-user');
    Route::delete('admin/deleteUser/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
});

// Todo routes
Route::get('/', [TodoController::class , 'showTodoList'])->name('main');
Route::get('filter-todos', [TodoController::class , 'changeSort'])->name('filter-todos');
Route::post('todo/save', [TodoController::class , 'createTodo'])->name('SaveItem');
Route::put('completion-status/{id}', [TodoController::class, 'changeCompletionStatus'])->name('changeCompletionStatus');
Route::delete('todo/delete/{id}', [TodoController::class, 'deleteTodoElement'])->name('deleteTodoElement');
Route::put('todo/update', [TodoController::class, 'updateTodoFields'])->name('updateTodoFields');

// Tag routes
Route::post('tag/add', [TodoController::class , 'addNewTagToTodo'])->name('addNewTag');
Route::post('tag/attach', [TodoController::class , 'attachTagToTodo'])->name('attachTag');
Route::delete('tag/remove/todo', [TodoController::class , 'removeTagAssociation'])->name('removeTagFromTodo');
Route::delete('tag/remove', [TodoController::class , 'removeTag'])->name('removeTag');
Route::put('tag/update', [TodoController::class , 'updateTag'])->name('updateTag');
Route::get('tags/filter', [TodoController::class , 'changeSelectedTags'])->name('filterByTags');
