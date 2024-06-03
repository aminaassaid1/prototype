<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pkg_notifications\notificationController;

Route::middleware('auth')->group(function () {
    Route::prefix('/notifications')->group(function () {
        Route::get('/', [notificationController::class, 'index'])->name('notification.index');
        Route::get('/notification/create', [notificationController::class, 'create'])->name('notification.create');
        Route::post('/notification/create', [notificationController::class, 'store'])->name('notification.store');
        Route::get('/notification/{id}/edit', [notificationController::class, 'edit'])->name('notification.edit');
        Route::put('/notification/{id}/update', [notificationController::class, 'update'])->name('notification.update');
        Route::put('/notification/{id}/destroy', [notificationController::class, 'destroy'])->name('notification.destroy');
        Route::get('/notification/{id}/show', [notificationController::class, 'show'])->name('notification.show');
        Route::get('/notification/export', [notificationController::class, 'export'])->name('notification.export');
        Route::post('/notification/import', [notificationController::class, 'import'])->name('notification.import');
        // Route::resource('/notifications', notificationController::class);
    });
});