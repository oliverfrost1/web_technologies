<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('Register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('Register', [RegisterController::class, 'register'])->name('register');
Route::get('Login', AuthController::class . '@show')->name('Login');
Route::post('Login', [AuthController::class, 'authenticate'])->name('Login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Profile routes
Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('Profile', function () {
    return view('Profile');
})->middleware('auth.basic')->name('profile');

// Admin routes
Route::middleware('admin')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/editUser/{id}', [AdminController::class, 'editUserForm'])->name('admin.edit-user');
    Route::put('admin/editUser/{id}', [AdminController::class, 'editUser'])->name('admin.edit-user');
    Route::delete('admin/deleteUser/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
});

// Todo routes
Route::get('/', TodoController::class . '@displayTodoListWithTags')->name('Main');
Route::get('toggleCompletedTodosVisibility', TodoController::class . '@toggleCompletedTodosVisibility')->name('toggleCompletedTodosVisibility');
Route::post('createTodo', TodoController::class . '@createTodo')->name('createTodo');
Route::put('updateTodo', [TodoController::class, 'updateTodo'])->name('updateTodo');
Route::delete('deleteTodo/{id}', [TodoController::class, 'deleteTodo'])->name('deleteTodo');
Route::put('toggleTodoCompletionStatus/{id}', [TodoController::class, 'toggleTodoCompletionStatus'])->name('toggleTodoCompletionStatus');

// Tag routes
Route::post('createOrAttachTagToTodo', TagController::class . '@createOrAttachTagToTodo')->name('createOrAttachTagToTodo');
Route::delete('detachTagFromTodo', TagController::class . '@detachTagFromTodo')->name('detachTagFromTodo');
Route::delete('deleteTag', TagController::class . '@deleteTag')->name('deleteTag');
Route::put('updateTag', TagController::class . '@updateTag')->name('updateTag');
Route::get('filterByTags', TagController::class . '@filterByTags')->name('filterByTags');
