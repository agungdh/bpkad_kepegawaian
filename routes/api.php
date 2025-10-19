<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    $user = $request->user();
    $pegawai = $user->pegawai;
    $pegawai->load('bidang', 'skpd');

    return $user;
})->middleware('auth:api');
