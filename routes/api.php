<?php

use App\Models\SessionJwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/', function () {
        $parts = explode('.', request()->bearerToken());
        if (count($parts) === 3) {
            $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
            $jti = $payload['jti'] ?? null;
        } else {
            $jti = null;
        }

        if (SessionJwt::where('jti', $jti)->doesntExist()) {
            abort(401);
        }
    });

    Route::get('/user', function (Request $request) {
        $user = $request->user();
        $pegawai = $user->pegawai;
        $pegawai->load('bidang', 'skpd');

        return $user;
    });
});
