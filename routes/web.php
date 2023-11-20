<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', TodoController::class . '@showTodoList')->name('Main');
Route::get('FilterTodos', TodoController::class . '@changeSort')->name('FilterTodos');
Route::get('Register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('Register', [RegisterController::class, 'register'])->name('register');
Route::get('Login', AuthController::class . '@show')->name('Login');
Route::post('Login', [AuthController::class, 'authenticate'])->name('Login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('Profile', function () {
    return view('Profile');
})->middleware('auth.basic')->name('profile');

Route::controller(AdminController::class)->middleware('admin')->group(function () {
    Route::get('admin/dashboard', 'dashboard')->name('admin.dashboard');
    Route::get('admin/editUser/{id}', 'editUserForm')->name('admin.edit-user');
    Route::put('admin/editUser/{id}', 'editUser')->name('admin.edit-user');
    Route::delete('admin/deleteUser/{id}', 'deleteUser')->name('admin.delete-user');
});

Route::post('createOrAttachTagToTodo', TodoController::class . '@createOrAttachTagToTodo')->name('createOrAttachTagToTodo');
Route::delete('detachTagFromTodo', TodoController::class . '@detachTagFromTodo')->name('detachTagFromTodo');
Route::delete('deleteTag', TodoController::class . '@deleteTag')->name('deleteTag');
Route::put('updateTag', TodoController::class . '@updateTag')->name('updateTag');

Route::get('filterByTags', TodoController::class . '@changeSelectedTags')->name('filterByTags');

Route::post('createTodo', TodoController::class . '@createTodo')->name('createTodo');

Route::put('changeCompletionStatus/{id}', [TodoController::class, 'changeCompletionStatus'])->name('changeCompletionStatus');
Route::delete('deleteTodo/{id}', [TodoController::class, 'deleteTodo'])->name('deleteTodo');
Route::put('updateTodo', [TodoController::class, 'updateTodo'])->name('updateTodo');
