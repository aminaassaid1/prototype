<?php

use App\Http\Controllers\pkg_projets\TaskController;
use Illuminate\Support\Facades\Route;


// routes for tasks management
Route::middleware('auth')->group(function () {
    Route::prefix('/projets')->group(function () {
        Route::resource('taches', TaskController::class);
        Route::get('taches/export', [TaskController::class, 'export'])->name('tache.export');
        Route::post('taches/import', [TaskController::class, 'import'])->name('tache.import');
        // digrame degant
        Route::get('projets/taches/digramme-de-gantt', [TaskController::class, 'indexGantt'])->name('taches.gantt');    });
});
