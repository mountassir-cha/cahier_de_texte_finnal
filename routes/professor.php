<?php

use App\Http\Controllers\ProfessorController;
use Illuminate\Support\Facades\Route;

Route::prefix('professor')->name('professor.')->group(function () {
    // Routes publiques (non authentifiées)
    Route::middleware('guest:professor')->group(function () {
        Route::get('/login', [ProfessorController::class, 'showLoginForm'])
            ->name('login')
            ->middleware('guest:professor');
    });
    
    Route::post('/login', [ProfessorController::class, 'login'])
        ->middleware('guest:professor');

    // Routes protégées (authentifiées)
    Route::middleware('auth:professor')->group(function () {
        Route::get('/', function () {
            return redirect()->route('professor.dashboard');
        });
        Route::get('/dashboard', [ProfessorController::class, 'dashboard'])->name('dashboard');
        Route::get('/cahier-texte', [ProfessorController::class, 'showCahierTexte'])->name('cahier-texte');
        Route::post('/cahier-texte', [ProfessorController::class, 'updateCahierTexte']);
        Route::get('/cahier-texte/content', [ProfessorController::class, 'getCahierTexteContent']);
        Route::post('/logout', [ProfessorController::class, 'logout'])->name('logout');

        // Routes pour la gestion des cours
        Route::prefix('courses')->name('courses.')->group(function () {
            Route::get('/', [ProfessorController::class, 'courses'])->name('index');
            Route::get('/create', [ProfessorController::class, 'createCourse'])->name('create');
            Route::post('/', [ProfessorController::class, 'storeCourse'])->name('store');
            Route::get('/{course}/edit', [ProfessorController::class, 'editCourse'])->name('edit');
            Route::put('/{course}', [ProfessorController::class, 'updateCourse'])->name('update');
            Route::delete('/{course}', [ProfessorController::class, 'deleteCourse'])->name('delete');
        });
    });
}); 