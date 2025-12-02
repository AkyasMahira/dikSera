<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PerawatController as AdminPerawatController;
use App\Http\Controllers\Perawat\DashboardController as PerawatDashboardController;
use App\Http\Controllers\Pewawancara\DashboardController as PewawancaraDashboardController;

Route::get('/', function () {
    return redirect()->route('auth.login');
});

// AUTH
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.process');

    Route::get('register-perawat', [AuthController::class, 'registerPerawatForm'])->name('register.perawat');
    Route::post('register-perawat', [AuthController::class, 'registerPerawat'])->name('register.perawat.process');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// PERAWAT
Route::get('/perawat/dashboard', [PerawatDashboardController::class, 'index'])->name('perawat.dashboard');

// ADMIN
Route::get('/admin/perawat',               [AdminPerawatController::class, 'index'])->name('admin.perawat.index');
Route::get('/admin/perawat/create',        [AdminPerawatController::class, 'create'])->name('admin.perawat.create');
Route::post('/admin/perawat',              [AdminPerawatController::class, 'store'])->name('admin.perawat.store');
Route::get('/admin/perawat/{id}',          [AdminPerawatController::class, 'show'])->name('admin.perawat.show');
Route::get('/admin/perawat/{id}/edit',     [AdminPerawatController::class, 'edit'])->name('admin.perawat.edit');
Route::put('/admin/perawat/{id}',          [AdminPerawatController::class, 'update'])->name('admin.perawat.update');
Route::delete('/admin/perawat/{id}',       [AdminPerawatController::class, 'destroy'])->name('admin.perawat.destroy');

// PEWAWANCARA
Route::get('/pewawancara/dashboard', [PewawancaraDashboardController::class, 'index'])->name('pewawancara.dashboard');
