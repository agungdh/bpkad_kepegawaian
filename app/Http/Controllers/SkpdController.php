<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SkpdController extends Controller
{
    public function datatable(Request $request)
    {
        $datas = Skpd::from(new Skpd()->getTable());

        return DataTables::of($datas)
            ->addColumn('action', function ($row) {
                return view('pages.skpd.action', ['row' => $row])->render();
            })
            ->make();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.skpd.index', compact([
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::select(['id', 'nama', 'nip'])->orderBy('nip')->get();

        return view('pages.skpd.form', compact([
            'pegawais',
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Skpd::query()->create($this->validated($request));

        $request->session()->flash('success', 'SKPD berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skpd $skpd)
    {
        return $skpd;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skpd $skpd)
    {
        return view('pages.skpd.form', compact([
            'skpd',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skpd $skpd)
    {
        $skpd->update($this->validated($request));

        $request->session()->flash('success', 'SKPD berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Skpd $skpd)
    {
        $skpd->delete();
    }

    private function validated(Request $request) {
        return $request->validate([
            'skpd' => 'required',
        ]);
    }
}
