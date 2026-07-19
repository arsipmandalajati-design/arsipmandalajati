<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arsip;
use App\Models\KodeArsip;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        $query = KodeArsip::with([
            'suratMasuk',
            'suratKeluar'
        ]);

        if ($request->filled('kode_arsip')) {
            $query->where(
                'kode',
                'LIKE',
                '%' . $request->kode_arsip . '%'
            );
        }

        if ($request->filled('nama_arsip')) {
            $query->where(
                'nama_arsip',
                'LIKE',
                '%' . $request->nama_arsip . '%'
            );
        }

        $kodearsip = $query->get();

        $totalArsip = $kodearsip->count();

        return view(
            'arsip.index',
            compact(
                'kodearsip',
                'totalArsip'
            )
        );
    }

    public function create()
    {
        $kodearsip = KodeArsip::with([
            'suratMasuk',
            'suratKeluar'
        ])->get();

        return view(
            'arsip.create',
            compact('kodearsip')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_arsip'    => 'required',
            'nama_arsip'    => 'required',
            'tanggal_arsip' => 'required',
            'file_arsip'    => 'required|file'
        ]);

        $file = $request->file('file_arsip')
                        ->store('arsip', 'public');

        Arsip::create([
            'kode_arsip'    => $request->kode_arsip,
            'nama_arsip'    => $request->nama_arsip,
            'tanggal_arsip' => $request->tanggal_arsip,
            'file_arsip'    => $file
        ]);

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Data arsip berhasil ditambahkan');
    }

    public function edit(Arsip $arsip)
    {
        return view(
            'arsip.edit',
            compact('arsip')
        );
    }

    public function update(Request $request, Arsip $arsip)
    {
        $arsip->update($request->all());

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Data arsip berhasil diupdate');
    }

    public function destroy(Arsip $arsip)
    {
        $arsip->delete();

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Data arsip berhasil dihapus');
    }
}