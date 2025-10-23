<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/', function () {});

    Route::get('/user', function (Request $request) {
        $user = $request->user();
        $pegawai = $user->pegawai;
        $pegawai->load('bidang', 'skpd');

        return $user;
    });
});
