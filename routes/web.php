<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// Admin Routes
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('karyawan', [AdminController::class, 'karyawan'])->name('karyawan');
    Route::get('login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('rekap-absensi', [AdminController::class, 'rekapAbsensi'])->name('rekap');
    Route::get('profil-admin', [AdminController::class, 'profilAdmin'])->name('profil');

    // Route untuk menampilkan form edit pengguna
    Route::get('/karyawan/{user}/edit', [AdminController::class, 'editKaryawan'])->name('karyawan.edit');

    // Route untuk memproses update pengguna
    Route::put('/karyawan/{user}', [AdminController::class, 'updateKaryawan'])->name('karyawan.update');

    //delete karyawan
    Route::delete('/karyawan/{user}', [AdminController::class, 'destroyKaryawan'])->name('karyawan.destroy');
});

// User Routes
Route::prefix('user')->name('user.')->group(function () {
    Route::get('absen', [UserController::class, 'showAbsenPage'])->name('absen');
    Route::get('history', [UserController::class, 'history'])->name('history');
    Route::get('home', [UserController::class, 'home'])->name('home');
    Route::get('profil', [UserController::class, 'profil'])->name('profil');
    Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
});

// Login route as root
Route::get('/', [UserController::class, 'login'])->name('user.login');

// Auth views for guest users
Route::middleware('guest')->group(function () {
    Route::view('register', 'auth.register')->name('register');
    Route::view('login', 'auth.login')->name('login');
});

// Logout route (handled by Fortify)
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
