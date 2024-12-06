<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PegawaiController extends Controller
{
    public function datatable(Request $request)
    {
        $pegawais = Pegawai::query();

        if ($request->sort) {
            $pegawais = $pegawais->orderBy($request->sort, $request->sort_desc ? 'desc' : 'asc');
        }

        if ($request->search) {
            $pegawais = $pegawais->where(function ($query) use ($request) {
                $columns = ['nip', 'nama'];

                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%'.$request->search.'%');
                }
            });
        }

        $count = $pegawais->count();
        $pegawais = $pegawais->cursorPaginate(10);

        $pegawais = $pegawais->toArray();
        $pegawais['count'] = $count;

        return $pegawais;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Pegawai/Index', compact([
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
