<?php

use App\Http\Controllers\BelajarMandiriController;
use App\Http\Controllers\CoachingController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiklatController;
use App\Http\Controllers\LcController;
use App\Http\Controllers\MentoringController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PpmController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\WebinarController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profil', [DashboardController::class, 'profil']);
    Route::post('/profil', [DashboardController::class, 'profilData']);
    Route::put('/profil', [DashboardController::class, 'profilUpdate']);

    Route::post('/pegawai/datatable', [PegawaiController::class, 'datatable']);
    Route::resource('/pegawai', PegawaiController::class);
});

require __DIR__.'/auth.php';
