<?php

use App\Http\Controllers\BidangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SkpdController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profil', [DashboardController::class, 'profil']);
    Route::post('/profil', [DashboardController::class, 'profilData']);
    Route::put('/profil', [DashboardController::class, 'profilUpdate']);

    Route::group(['prefix' => '/helper'], function () {
        Route::post('/getBidangBySkpd/{skpd}', [HelperController::class, 'getBidangBySkpd']);
    });

    Route::group(['prefix' => '/skpd'], function () {
        Route::post('/datatable', [SkpdController::class, 'datatable']);
        Route::resource('/', SkpdController::class);
    });

    Route::group(['prefix' => '/bidang'], function () {
        Route::post('/datatable', [BidangController::class, 'datatable']);
        Route::resource('/', BidangController::class);
    });

    Route::group(['prefix' => '/pegawai'], function () {
        Route::post('/datatable', [PegawaiController::class, 'datatable']);
        Route::resource('/', PegawaiController::class);
    });
});

require __DIR__.'/auth.php';
