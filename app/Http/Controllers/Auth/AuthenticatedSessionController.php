<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\SessionJwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    public function redirect(Request $request)
    {
        $sessionId = $request->session()->getId();

        $encryptedJti = $request->jti;
        $jti = Crypt::decryptString($encryptedJti);

        SessionJwt::query()->create([
            'session_id' => $sessionId,
            'jti' => $jti,
        ]);

        return redirect($request->redirect_to);
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $user->load('pegawai.bidang');

        return $user;
    }

    /**
     * Show the login page.
     */
    public function create()
    {
        return view('pages.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $request->session()->save();

        DB::table('sessions')->where('id', $request->session()->getId())->update([
            'user_uuid' => $request->user()->uuid,
        ]);

        $request->session()->flash('success', 'Login berhasil. Selamat datang !!!');

        return $request->session()->get('url.intended', route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($request->redirect_to ?? '/');
    }
}
