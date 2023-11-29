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
Route::put('profile/update', [ProfileController::class, 'update'])->name('Profile.update');
Route::get('Profile', function () {
    return view('Profile');
})->middleware('auth.basic')->name('Profile');

Route::controller(AdminController::class)->middleware('admin')->group(function () {
    Route::get('admin/dashboard', 'dashboard')->name('admin.dashboard');
    Route::get('admin/editUser/{id}', 'editUserForm')->name('admin.edit-user');
    Route::put('admin/editUser/{id}', 'editUser')->name('admin.edit-user');
    Route::delete('admin/deleteUser/{id}', 'deleteUser')->name('admin.delete-user');
});

Route::post('addNewTag', TodoController::class . '@addNewTagToTodo')->name('addNewTag');
Route::post('attachTag', TodoController::class . '@attachTagToTodo')->name('attachTag');
Route::delete('removeTagFromTodo', TodoController::class . '@removeTagAssociation')->name('removeTagFromTodo');
Route::delete('removeTag', TodoController::class . '@removeTag')->name('removeTag');
Route::put('updateTag', TodoController::class . '@updateTag')->name('updateTag');

Route::get('filterByTags', TodoController::class . '@changeSelectedTags')->name('filterByTags');

Route::post('SaveItem', TodoController::class . '@createTodo')->name('SaveItem');

Route::put('changeCompletionStatus/{id}', [TodoController::class, 'changeCompletionStatus'])->name('changeCompletionStatus');
Route::delete('deleteTodoElement/{id}', [TodoController::class, 'deleteTodoElement'])->name('deleteTodoElement');
Route::put('updateTodoFields', [TodoController::class, 'updateTodoFields'])->name('updateTodoFields');
