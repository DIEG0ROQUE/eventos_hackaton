<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamController;

Route::get('/', [EventController::class, 'index'])->name('home');

// Incluir rutas de autenticación
require __DIR__.'/auth.php';

Route::prefix('eventos')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{event}', [EventController::class, 'show'])->name('show');
    Route::post('/{event}/register', [EventController::class, 'register'])->name('register');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function() {
        return view('dashboard');
    })->name('dashboard');
});