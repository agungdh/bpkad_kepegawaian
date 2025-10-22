<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
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
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
