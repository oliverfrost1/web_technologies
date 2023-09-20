<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todocontroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return view('TodoListMainPage', ["todos" => ["fsdfs", "2", "3", "4"]]);
})->name('forms');


Route::post("/SaveItem", [todocontroller::class, "store"])->name("SaveItem");