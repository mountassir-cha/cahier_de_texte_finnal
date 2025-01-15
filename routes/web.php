<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Register routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
        ->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])
        ->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Routes du tableau de bord (protégées par auth)
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    
    // Resource routes
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');
    Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
    Route::get('/classes/edit/{id}', [ClassController::class, 'edit'])->name('classes.edit');
    Route::put('/classes/update/{id}', [ClassController::class, 'update'])->name('classes.update');
    Route::delete('/classes/delete/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');
    Route::get('/professors', [ProfessorController::class, 'index'])->name('professors.index');
    Route::get('/professors/create', [ProfessorController::class, 'create'])->name('professors.create');
    Route::post('/professors', [ProfessorController::class, 'store'])->name('professors.store');
    Route::get('/professors/edit/{id}', [ProfessorController::class, 'edit'])->name('professors.edit');
    Route::put('/professors/update/{id}', [ProfessorController::class, 'update'])->name('professors.update');
    Route::delete('/professors/delete/{id}', [ProfessorController::class, 'destroy'])->name('professors.destroy');
    Route::resource('subjects', SubjectController::class);
    Route::resource('courses', CourseController::class);
    
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
});

Route::middleware('guest:professor')->group(function () {
    Route::get('/professor/login', [ProfessorController::class, 'showLoginForm'])->name('professor.login');
    Route::post('/professor/login', [ProfessorController::class, 'login']);
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login']);
});

Route::middleware('auth:professor')->group(function () {
    Route::get('/professor/dashboard', [ProfessorController::class, 'dashboard'])->name('professor.dashboard');
    Route::post('/professor/logout', [ProfessorController::class, 'logout'])->name('professor.logout');
    Route::get('/professor/cahier-texte', [ProfessorController::class, 'showCahierTexte'])->name('professor.cahier-texte');
    Route::post('/professor/cahier-texte', [ProfessorController::class, 'updateCahierTexte'])->name('professor.cahier-texte.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Routes admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminController::class, 'login']);
    });

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        // Autres routes admin...
    });
});
