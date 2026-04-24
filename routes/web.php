<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\TicketController as UserTicketController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// ================= GUEST (BELUM LOGIN) =================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // ✅ logout (bebas)
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // ✅ halaman wajib isi profil (TIDAK kena middleware)
        Route::get('/profile/complete', [UserProfileController::class, 'completeForm'])->name('profile.complete');
        Route::post('/profile/complete', [UserProfileController::class, 'completeStore'])->name('profile.complete.store');

        // ✅ SEMUA YANG DIKUNCI
        Route::middleware('profile.complete')->group(function () {

            Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

            Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
            Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');

            Route::resource('tickets', UserTicketController::class);

        });
    });


// ================= ADMIN =================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/profile/complete', [AdminProfileController::class, 'completeForm'])->name('profile.complete');
        Route::post('/profile/complete', [AdminProfileController::class, 'completeStore'])->name('profile.complete.store');

        Route::middleware('admin.profile.complete')->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            Route::resource('tickets', AdminTicketController::class);

            Route::post('tickets/{id}/response', [AdminTicketController::class, 'sendResponse'])->name('tickets.response');
            Route::put('tickets/{id}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
            Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
            Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
        });
    });
    