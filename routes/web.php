<?php

use App\Http\Controllers\LombaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PendaftaranController; // Ensure this is imported

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lombas/{lomba}', [LombaController::class, 'show'])->name('lombas.show');

// Authenticated User Routes (Both Roles)
Route::middleware(['auth'])->group(function () {
    // Comments
    Route::post('/lombas/{lomba}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read.all');
});

// Mahasiswa Specific Routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/profile', [MahasiswaController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [MahasiswaController::class, 'updateProfile'])->name('profile.update');
    Route::get('/riwayatlomba', [MahasiswaController::class, 'riwayatLomba'])->name('riwayat.lomba');
    
    // Updated route for student registration to avoid conflict with admin routes
    Route::post('/lomba/{lomba}/daftar', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
});

// Admin Specific Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/lomba/{lomba}/pendaftar', [AdminController::class, 'pendaftarLomba'])->name('lomba.pendaftar');
    
    // New route for updating pendaftaran status
    Route::put('/pendaftarans/{pendaftaran}/status', [AdminController::class, 'updatePendaftaranStatus'])->name('pendaftarans.updateStatus');
    
    Route::get('/lombas', [LombaController::class, 'index'])->name('index');
    Route::get('/lombas/create', [LombaController::class, 'create'])->name('create');
    Route::post('/lombas', [LombaController::class, 'store'])->name('store');
    Route::get('/lombas/{lomba}/edit', [LombaController::class, 'edit'])->name('edit');
    Route::put('/lombas/{lomba}', [LombaController::class, 'update'])->name('update');
    Route::delete('/lombas/{lomba}', [LombaController::class, 'destroy'])->name('destroy');
});

// The previous 'Rename pendaftaran route' section is no longer needed as it's now correctly placed within the 'mahasiswa' group above.