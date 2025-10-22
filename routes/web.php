<?php

use App\Http\Controllers\BidangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SkpdController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    return DB::table('sessions')->where('id', $request->session()->getId())->first();
});

Route::redirect('/', '/dashboard')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profil', [DashboardController::class, 'profil']);
    Route::post('/profil', [DashboardController::class, 'profilData']);
    Route::put('/profil', [DashboardController::class, 'profilUpdate']);

    Route::prefix('/helper')->group(function () {
        Route::post('/getBidangBySkpd/{skpd}', [HelperController::class, 'getBidangBySkpd']);
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::post('/skpd/datatable', [SkpdController::class, 'datatable']);
        Route::resource('/skpd', SkpdController::class);

        Route::post('/bidang/datatable', [BidangController::class, 'datatable']);
        Route::resource('/bidang', BidangController::class);

        Route::post('/pegawai/datatable', [PegawaiController::class, 'datatable']);
        Route::resource('/pegawai', PegawaiController::class);
    });
});

require __DIR__ . '/auth.php';
