<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Throwable;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.dashboard', compact([

        ]));
    }

    public function profil(Request $request)
    {
        $pegawai = Auth::user()->pegawai;

        return view('pages.profil', compact([
            'pegawai',
        ]));
    }

    public function profilData(Request $request)
    {
        $pegawai = Auth::user()->pegawai;

        $pegawai->load([
            'skpd',
            'bidang',
        ]);

        return $pegawai;
    }

    /**
     * @throws Throwable
     */
    public function profilUpdate(Request $request)
    {
        $pegawai = Auth::user()->pegawai;

        $data = $request->validate([
            'nama' => 'required|string',
            'nip' => [
                'required',
                'numeric',
                // rule unique bisa adaptif
                Rule::unique('pegawais', 'nip')->ignore($pegawai?->id),
                Rule::unique('users', 'username')->ignore($pegawai?->user?->id),
            ],
            // password rules bisa beda antara create/update
            'password' => ['nullable', 'confirmed'],
            'password_confirmation' => ['nullable', 'same:password'],
        ]);

        DB::transaction(function () use ($data, $pegawai) {
            $userData = [
                'username' => $data['nip'],
            ];
            if ($data['password']) {
                $userData['password'] = $data['password'];
            }
            $pegawai->user->update($userData);

            $pegawai->update([
                'nama' => $data['nama'],
                'nip' => $data['nip'],
            ]);
        });

        $request->session()->flash('success', 'Profil berhasil disimpan.');
    }
}
