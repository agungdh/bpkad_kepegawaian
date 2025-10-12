<?php

use App\Http\Controllers\DashboardController;
use App\Models\Bidang;
use Illuminate\Support\Facades\Route;

Route::get('/tehe', function () {
    $bidang = Bidang::with('pegawais.bidang.pegawais.user')->findByUuid('f7ef94f9-441d-44d5-83ab-f4b41f7beb2a');
//    dd($bidang);
    return $bidang;
    $bidangs = Bidang::with('pegawais.bidang.pegawais.user')->get();
//    dd($bidangs->first()->pegawais->first()->user);
    return $bidangs;
});

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
