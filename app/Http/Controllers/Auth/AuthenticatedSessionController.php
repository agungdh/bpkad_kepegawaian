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
        $driver = Session::getDrivers()[Session::getDefaultDriver()];
        $dbId = $driver->getId();

        Log::info('sebelum auth: '. $dbId);
        $request->authenticate();

        Log::info('sebelum regen: '. $dbId);
        $request->session()->regenerate();

        Log::info('sebelum update db: '. $dbId);
        $dbSessBef = DB::table('sessions')->where('id', $dbId)->first();
        DB::table('sessions')->where('id', $dbId)->update([
            'user_uuid' => $request->user()->uuid,
        ]);
        $dbSess = DB::table('sessions')->where('id', $dbId)->first();
        Session::put('sess_data', [
            'id' => $dbId,
            'dbSessBef' => $dbSessBef,
            'dbSess' => $dbSess,
            'user_uuid' => $request->user()->uuid,
        ]);

        Log::info('sebelum flash: '. $dbId);
        $request->session()->flash('success', 'Login berhasil. Selamat datang !!!');

        Log::info('sebelum return: '. $dbId);
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
