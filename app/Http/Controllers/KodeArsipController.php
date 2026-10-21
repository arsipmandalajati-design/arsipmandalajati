<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KodeArsip;

class KodeArsipController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR KODE ARSIP
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = KodeArsip::query();

        // Filter Kode Arsip
        if ($request->filled('kode')) {

            $query->where(
                'kode',
                'LIKE',
                '%' . $request->kode . '%'
            );

        }

        // Filter Nama Arsip
        if ($request->filled('nama_arsip')) {

            $query->where(
                'nama_arsip',
                'LIKE',
                '%' . $request->nama_arsip . '%'
            );

        }

        $kodearsip = $query
            ->latest()
            ->get();

        $totalKodeArsip = $kodearsip->count();

        return view(
            'kodearsip.index',
            compact(
                'kodearsip',
                'totalKodeArsip'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('kodearsip.create');
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'kode' => 'required|unique:kode_arsips,kode',

            'nama_arsip' => 'required|max:255',

            'keterangan' => 'nullable|max:500',

        ]);

        KodeArsip::create([

            'kode' => $request->kode,

            'nama_arsip' => $request->nama_arsip,

            'keterangan' => $request->keterangan,

        ]);

        return redirect()
            ->route('kodearsip.index')
            ->with(
                'success',
                'Kode arsip berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(KodeArsip $kodearsip)
    {
        return view(
            'kodearsip.edit',
            compact('kodearsip')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, KodeArsip $kodearsip)
    {
        $request->validate([

            'kode' =>
                'required|unique:kode_arsips,kode,' . $kodearsip->id,

            'nama_arsip' => 'required|max:255',

            'keterangan' => 'nullable|max:500',

        ]);

        $kodearsip->update([

            'kode' => $request->kode,

            'nama_arsip' => $request->nama_arsip,

            'keterangan' => $request->keterangan,

        ]);

        return redirect()
            ->route('kodearsip.index')
            ->with(
                'success',
                'Kode arsip berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA
    |--------------------------------------------------------------------------
    */

    public function destroy(KodeArsip $kodearsip)
    {
        $kodearsip->delete();

        return redirect()
            ->route('kodearsip.index')
            ->with(
                'success',
                'Kode arsip berhasil dihapus.'
            );
    }
}