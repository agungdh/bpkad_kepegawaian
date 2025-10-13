<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\Skpd;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BidangController extends Controller
{
    public function datatable(Request $request)
    {
        $datas = Bidang::from(new Bidang()->getTable() . ' as b');
        $datas->select([
            'b.*',
            's.skpd',
        ]);
        $datas = $datas->join(new Skpd()->getTable().' as s', 'b.skpd_id', '=', 's.id');

        return DataTables::of($datas)
            ->addColumn('action', function ($row) {
                return view('pages.bidang.action', ['row' => $row])->render();
            })
            ->make();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.bidang.index', compact([
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skpds = Skpd::query()->get();

        return view('pages.bidang.form', compact([
            'skpds',
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Bidang::query()->create($this->validated($request));

        $request->session()->flash('success', 'Bidang berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bidang $bidang)
    {
        $bidang->load('skpd');

        return $bidang;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidang $bidang)
    {
        $skpds = Skpd::query()->get();

        return view('pages.bidang.form', compact([
            'bidang',
            'skpds',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidang $bidang)
    {
        $bidang->update($this->validated($request));

        $request->session()->flash('success', 'Bidang berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Bidang $bidang)
    {
        $bidang->delete();
    }

    private function validated(Request $request) {
        $data = $request->validate([
            'skpd' => 'required|exists:skpds,uuid',
            'bidang' => 'required',
        ]);

        $data['skpd_id'] = Skpd::query()->findOrFailByUuid($data['skpd'])->id;

        unset($data['skpd']);

        return $data;
    }
}
