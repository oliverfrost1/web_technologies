<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('auth/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('auth/register', [RegisterController::class, 'register'])->name('register');
Route::get('auth/login', [AuthController::class , 'show'])->name('login');
Route::post('auth/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes
Route::get('profile', [ProfileController::class, 'getProfilePage'])->middleware('auth.basic')->name('profile');
Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');

// Admin routes
Route::middleware('admin')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/users/{id}/edit', [AdminController::class, 'editUserForm'])->name('admin.edit-user-form');
    Route::put('admin/users/{id}', [AdminController::class, 'editUser'])->name('admin.edit-user');
    Route::delete('admin/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
});

// Todo routes
Route::get('/', [TodoController::class , 'showTodoList'])->name('main');
Route::get('todos/visibility', [TodoController::class , 'changeSort'])->name('filter-todos');
Route::post('todos', [TodoController::class , 'createTodo'])->name('createTodoElement');
Route::put('todos/{id}/completion', [TodoController::class, 'changeCompletionStatus'])->name('changeCompletionStatus');
Route::delete('todos/{id}', [TodoController::class, 'deleteTodoElement'])->name('deleteTodoElement');
Route::put('todos/{id}', [TodoController::class, 'updateTodoFields'])->name('updateTodoFields');

// Tag routes
Route::post('todos/{id}/tags', [TodoController::class , 'addNewTagToTodo'])->name('addNewTag');
Route::delete('todos/{todoId}/tags/{tagId}', [TodoController::class , 'removeTagAssociation'])->name('removeTagFromTodo');
Route::delete('tags/{id}', [TodoController::class , 'removeTag'])->name('removeTag');
Route::put('tags/{id}', [TodoController::class , 'updateTag'])->name('updateTag');
Route::get('tags/filter', [TodoController::class , 'changeSelectedTags'])->name('filterByTags');
