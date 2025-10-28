<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Raiz: direciona para as tarefas; se não autenticado, será redirecionado ao login
Route::get('/', fn () => redirect()->route('tasks.index'));

// Rotas protegidas por autenticação (bônus)
Route::middleware('auth')->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::get('tasks/{task}/confirm-delete', [TaskController::class, 'confirmDelete'])->name('tasks.confirm-delete');
    Route::get('tasks-trashed', [TaskController::class, 'trashed'])->name('tasks.trashed');
    Route::post('tasks/{id}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
});

// Rotas de autenticação (login, registro, etc.)
require __DIR__.'/auth.php';
