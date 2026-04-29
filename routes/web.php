<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\TicketController as UserTicketController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\MessageController as UserMessageController;
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


// ================= USER =================
Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/profile/complete', [UserProfileController::class, 'completeForm'])->name('profile.complete');
        Route::post('/profile/complete', [UserProfileController::class, 'completeStore'])->name('profile.complete.store');

        Route::middleware('profile.complete')->group(function () {

            Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

            Route::post('tickets/{id}/response', [UserTicketController::class, 'sendResponse'])->name('tickets.response');
            Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
            Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
            Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
            Route::get('/messages/inbox', [UserMessageController::class, 'inbox'])->name('messages.inbox');

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
            Route::post('tickets/{id}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
            Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
            Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
            Route::post('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
            Route::get('/messages/inbox', [AdminMessageController::class, 'inbox'])->name('messages.inbox');

            // ================= KELOLA ADMIN =================
            // Halaman daftar admin (SEMUA ADMIN BISA AKSES)
            Route::get('/manage-admins', [ManageAdminController::class, 'index'])->name('manage-admins.index');
            
            // Hanya admin utama (ID=1) yang bisa akses create, edit, update, delete
            Route::middleware(['main.admin'])->group(function () {
                Route::get('/manage-admins/create', [ManageAdminController::class, 'create'])->name('manage-admins.create');
                Route::post('/manage-admins', [ManageAdminController::class, 'store'])->name('manage-admins.store');
                Route::get('/manage-admins/{id}/edit', [ManageAdminController::class, 'edit'])->name('manage-admins.edit');
                Route::put('/manage-admins/{id}', [ManageAdminController::class, 'update'])->name('manage-admins.update');
                Route::delete('/manage-admins/{id}', [ManageAdminController::class, 'destroy'])->name('manage-admins.destroy');
            });
            
        }); 
    }); 