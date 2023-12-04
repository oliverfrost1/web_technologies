<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('auth/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('auth/register', [RegisterController::class, 'register'])->name('register');
Route::get('auth/login', AuthController::class . '@show')->name('login');
Route::post('auth/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes
Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('profile', function () {
    return view('Profile');
})->middleware('auth.basic')->name('profile');

// Admin routes
Route::middleware('admin')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/users/{id}/edit', [AdminController::class, 'editUserForm'])->name('admin.edit-user-form');
    Route::put('admin/users/{id}', [AdminController::class, 'editUser'])->name('admin.edit-user');
    Route::delete('admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
});

// Todo routes
Route::get('todos', TodoController::class . '@displayTodoListWithTags')->name('main');
Route::get('todos/visibility', TodoController::class . '@toggleCompletedTodosVisibility')->name('toggleCompletedTodosVisibility');
Route::post('todos', TodoController::class . '@createTodo')->name('createTodo');
Route::put('todos/{id}', [TodoController::class, 'updateTodo'])->name('updateTodo');
Route::delete('todos/{id}', [TodoController::class, 'deleteTodo'])->name('deleteTodo');
Route::put('todos/{id}/completion', [TodoController::class, 'toggleTodoCompletionStatus'])->name('toggleTodoCompletionStatus');

// Tag routes
Route::post('todos/{id}/tags', TagController::class . '@createOrAttachTagToTodo')->name('createOrAttachTagToTodo');
Route::delete('todos/{todoId}/tags/{tagId}', TagController::class . '@detachTagFromTodo')->name('detachTagFromTodo');
Route::delete('tags/{id}', TagController::class . '@deleteTag')->name('deleteTag');
Route::put('tags/{id}', TagController::class . '@updateTag')->name('updateTag');
Route::get('tags/filter', TagController::class . '@filterByTags')->name('filterByTags');
