<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', [AuthController::class, 'welcome']);

// authentication
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/home', [AuthController::class, 'home'])->name('home');


Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/materias', [AdminController::class, 'indexMaterias'])->name('materias');
Route::post('/materias', [AdminController::class, 'saveMateria']);
Route::get('/materias/{id}/edit', [AdminController::class, 'editMateria'])->name('materias.edit');
Route::put('/materias/{id}', [AdminController::class, 'updateMateria'])->name('materias.update');
Route::delete('/materias/{id}', [AdminController::class, 'deleteMateria'])->name('materias.delete');
