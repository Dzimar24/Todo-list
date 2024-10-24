<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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

Route::get('/', [TodoController::class, 'index'])->name('todos');
Route::put('/todos/{id}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/tudos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');
Route::post('/tudos', [TodoController::class, 'store'])->name('todos.store');

//? Route Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/process', [LoginController::class, 'process'])->name('process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
