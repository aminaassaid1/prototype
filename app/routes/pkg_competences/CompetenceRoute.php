<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pkg_competences\CompetenceController;
use App\Models\pkg_competences\Competence;

// routes for competence management
Route::middleware('auth')->group(function () {
    $namespace = 'App\Http\Controllers\pkg_competences';
    Route::namespace($namespace)->group(function () {
        Route::prefix('competences')->group(function () {
            Route::get('/', [CompetenceController::class, 'index'])->name('competence.index');
            Route::get('/Competence/form-ajouter', [CompetenceController::class, 'create'])->name('competence.create');
            Route::post('/Competence/ajouter', [CompetenceController::class, 'store'])->name('competence.store');
            Route::get('/Competence/{id}', [CompetenceController::class, 'show'])->name('competence.show');
            Route::get('/Competence/{id}/edit', [CompetenceController::class, 'edit'])->name('competence.edit');
            Route::put('/Competence/{id}/update', [CompetenceController::class, 'update'])->name('competence.update');
            Route::delete('/Competence/{id}/delete', [CompetenceController::class, 'destroy'])->name('competence.delete');
            Route::get('/Competence/export', [CompetenceController::class, 'export'])->name('competence.export');
        Route::post('/Competence/import', [CompetenceController::class, 'import'])->name('competence.import');
        });
    });
});
