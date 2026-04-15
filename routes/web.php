<?php

use App\Http\Controllers\DashboardController;
<<<<<<< HEAD
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\User\TicketController;
=======
>>>>>>> 0427184526c5dd354cf4f90f4767968228efb2b1
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// ========== GUEST ROUTES (belum login) ==========
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ========== AUTH ROUTES (sudah login) ==========
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

<<<<<<< HEAD
    Route::post('tickets/{id}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
    Route::post('tickets/{id}/close', [TicketController::class, 'close'])->name('tickets.close');

    Route::resource('tickets', TicketController::class);
});
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('tickets', AdminTicketController::class);
=======
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); // ← AKTIFKAN INI
>>>>>>> 0427184526c5dd354cf4f90f4767968228efb2b1
});