<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// Admin routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/karyawan', [AdminController::class, 'karyawan'])->name('admin.karyawan');
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/admin/rekap-absensi', [AdminController::class, 'rekapAbsensi'])->name('admin.rekap');
Route::get('/admin/profil-admin', [AdminController::class, 'profilAdmin'])->name('admin.profil');

// User routes
Route::get('/user/absen', [UserController::class, 'absen'])->name('user.absen');
Route::get('/user/history', [UserController::class, 'history'])->name('user.history');
Route::get('/user/home', [UserController::class, 'home'])->name('user.home');
Route::get('/', [UserController::class, 'login'])->name('user.login');
Route::get('/user/profil', [UserController::class, 'profil'])->name('user.profil');
