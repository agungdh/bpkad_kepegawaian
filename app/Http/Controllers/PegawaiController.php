<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Skpd;
use Illuminate\Http\Request;
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
        $datas = $datas->join(new Skpd()->getTable().' as s', 'p.skpd_id', '=', 's.id');
        $datas = $datas->join(new Skpd()->getTable().' as b', 'p.bidang_id', '=', 'b.id');

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
     */
    public function store(Request $request)
    {
        Pegawai::query()->create($this->validated($request));

        $request->session()->flash('success', 'Pegawai berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        $pegawai->load('skpd');

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
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $pegawai->update($this->validated($request));

        $request->session()->flash('success', 'Pegawai berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Pegawai $pegawai)
    {
        $pegawai->delete();
    }

    private function validated(Request $request)
    {
        $data = $request->validate([
            'skpd' => 'required|exists:skpds,uuid',
            'pegawai' => 'required',
        ]);

        $data['skpd_id'] = Skpd::query()->findOrFailByUuid($data['skpd'])->id;

        unset($data['skpd']);

        return $data;
    }
}
