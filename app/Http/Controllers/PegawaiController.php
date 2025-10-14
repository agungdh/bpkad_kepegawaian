<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Pegawai;
use App\Models\Skpd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    public function datatable(Request $request)
    {
        $datas = Pegawai::from(new Pegawai()->getTable().' as p');
        $datas->select([
            'p.*',
            's.skpd',
            'b.bidang',
        ]);
        $datas = $datas->leftJoin(new Skpd()->getTable().' as s', 'p.skpd_id', '=', 's.id');
        $datas = $datas->leftJoin(new Bidang()->getTable().' as b', 'p.bidang_id', '=', 'b.id');

        return DataTables::of($datas)
            ->addColumn('action', function ($row) {
                return view('pages.pegawai.action', ['row' => $row])->render();
            })
            ->make();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.pegawai.index', compact([
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skpds = Skpd::query()->get();

        return view('pages.pegawai.form', compact([
            'skpds',
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Throwable
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $data = $this->validated($request);

            $user = User::create([
                'username' => $data['nip'],
                'password' => $data['password'],
            ])->assignRole('pegawai');

            Pegawai::create([
                'user_id' => $user->id,
                'skpd_id' => $data['skpd_id'],
                'bidang_id' => $data['bidang_id'],
                'nama' => $data['nama'],
                'nip' => $data['nip'],
            ]);
        });

        $request->session()->flash('success', 'Pegawai berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        $pegawai->load('bidang.skpd', 'skpd');

        return $pegawai;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        $skpds = Skpd::query()->get();

        return view('pages.pegawai.form', compact([
            'pegawai',
            'skpds',
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Throwable
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        DB::transaction(function () use ($request, $pegawai) {
            $data = $this->validated($request, $pegawai);

            $userData = [
                'username' => $data['nip'],
            ];
            if ($request->password) {
                $userData['password'] = $data['password'];
            }
            $pegawai->user->update($userData);

            $pegawai->update([
                'skpd_id' => $data['skpd_id'],
                'bidang_id' => $data['bidang_id'],
                'nama' => $data['nama'],
                'nip' => $data['nip'],
            ]);
        });

        $request->session()->flash('success', 'Pegawai berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Throwable
     */
    public function destroy(Request $request, Pegawai $pegawai)
    {
        DB::transaction(function () use ($pegawai) {
            $pegawai->delete();
            $pegawai->user->delete();
        });
    }

    private function validated(Request $request, ?Pegawai $pegawai = null)
    {
        $isUpdate = $pegawai !== null;

        $data = $request->validate([
            'skpd' => 'required|exists:skpds,uuid',
            'bidang' => [
                'required',
                'exists:bidangs,uuid',
                function ($attribute, $value, $fail) use ($request) {
                    if (Bidang::query()->findOrFailByUuid($value)->skpd->uuid != $request->skpd) {
                        $fail('The Bidang is not matched with the SKPD.');
                    }
                },
            ],
            'nama' => 'required|string',
            'nip' => [
                'required',
                'numeric',
                // rule unique bisa adaptif
                Rule::unique('pegawais', 'nip')->ignore($pegawai?->id),
                Rule::unique('users', 'username')->ignore($pegawai?->user?->id),
            ],
            // password rules bisa beda antara create/update
            'password' => [$isUpdate ? 'nullable' : 'required', 'confirmed'],
            'password_confirmation' => [$isUpdate ? 'nullable' : 'required', 'same:password'],
        ]);

        $data['skpd_id'] = Skpd::query()->findOrFailByUuid($data['skpd'])->id;
        $data['bidang_id'] = Bidang::query()->findOrFailByUuid($data['bidang'])->id;

        unset($data['skpd'], $data['bidang']);

        return $data;
    }
}
