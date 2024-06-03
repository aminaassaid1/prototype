<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pkg_autorisations\utilisateursController;
use App\Models\pkg_competences\Competence;

// routes for competence management
Route::middleware('auth')->group(function () {
    $namespace = 'App\Http\Controllers\pkg_autorisations';
    Route::namespace($namespace)->group(function () {
        Route::prefix('utilisateurs')->group(function () {
            Route::get('/', [utilisateursController::class, 'index'])->name('utilisateur.index');
            Route::get('/{id}', [utilisateursController::class, 'show'])->name('utilisateur.show');
            Route::get('/utilisateur/export', [utilisateursController::class, 'export'])->name('utilisateur.export');

        });
    });
});
