<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TareaController;

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

// Horarios
Route::get('/horarios', [AdminController::class, 'indexHorarios'])->name('horarios');
Route::post('/horarios', [AdminController::class, 'saveHorario']);
Route::get('/horarios/{id}/edit', [AdminController::class, 'editHorario'])->name('horarios.edit');
Route::put('/horarios/{id}', [AdminController::class, 'updateHorario'])->name('horarios.update');
Route::delete('/horarios/{id}', [AdminController::class, 'deleteHorario'])->name('horarios.delete');

// Grupos
Route::get('/grupos', [AdminController::class, 'indexGrupos'])->name('grupos');
Route::post('/grupos', [AdminController::class, 'saveGrupo']);
Route::get('/grupos/{id}/edit', [AdminController::class, 'editGrupo'])->name('grupos.edit');
Route::put('/grupos/{id}', [AdminController::class, 'updateGrupo'])->name('grupos.update');
Route::delete('/grupos/{id}', [AdminController::class, 'deleteGrupo'])->name('grupos.delete');

// Inscripciones
Route::get('/inscripciones', [AdminController::class, 'indexInscripciones'])->name('inscripciones');
Route::post('/inscripciones', [AdminController::class, 'saveInscripcion']);
Route::get('/inscripciones/{id}/edit', [AdminController::class, 'editInscripcion'])->name('inscripciones.edit');
Route::put('/inscripciones/{id}', [AdminController::class, 'updateInscripcion'])->name('inscripciones.update');
Route::delete('/inscripciones/{id}', [AdminController::class, 'deleteInscripcion'])->name('inscripciones.delete');

// Calificaciones
Route::get('/calificaciones', [AdminController::class, 'indexCalificaciones'])->name('calificaciones');
Route::post('/calificaciones', [AdminController::class, 'saveCalificacion']);
Route::get('/calificaciones/{id}/edit', [AdminController::class, 'editCalificacion'])->name('calificaciones.edit');
Route::put('/calificaciones/{id}', [AdminController::class, 'updateCalificacion'])->name('calificaciones.update');
Route::delete('/calificaciones/{id}', [AdminController::class, 'deleteCalificacion'])->name('calificaciones.delete');

// Tareas

Route::middleware('auth')->group(function () {
    Route::get('/tareas', [TareaController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/create', [TareaController::class, 'create'])->name('tareas.create');
    Route::post('/tareas', [TareaController::class, 'store'])->name('tareas.store');
    Route::get('/tareas/{id}', [TareaController::class, 'show'])->name('tareas.show');
    Route::post('/tareas/{id}/entrega', [TareaController::class, 'storeEntrega'])->name('tareas.entrega');
    Route::post('/tareas/{tareaId}/entregas/{entregaId}/revisar', [TareaController::class, 'reviewEntrega'])->name('tareas.entrega.revisar');
    Route::get('/tareas/{tareaId}/entregas/{entregaId}/descargar', [TareaController::class, 'downloadEntrega'])->name('tareas.entrega.descargar');
});
