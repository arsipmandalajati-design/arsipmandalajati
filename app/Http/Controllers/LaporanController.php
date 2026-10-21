<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Agenda::query();

        if (Auth::user()->role == 'pegawai') {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('nama_kegiatan')) {
            $query->where('nama_kegiatan', 'like', '%' . $request->nama_kegiatan . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $laporan = $query->orderBy('tanggal', 'desc')
                         ->paginate(10)
                         ->withQueryString();

        $statistik = [
            'total'     => (clone $query)->count(),
            'terjadwal' => (clone $query)->where('status', 'Terjadwal')->count(),
            'selesai'   => (clone $query)->where('status', 'Selesai')->count(),
            'ditunda'   => (clone $query)->where('status', 'Ditunda')->count(),
        ];

        return view('laporankegiatan.index', compact('laporan', 'statistik'));
    }

    public function print(Request $request)
    {
        $query = Agenda::query();

        if (Auth::user()->role == 'pegawai') {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('nama_kegiatan')) {
            $query->where('nama_kegiatan', 'like', '%' . $request->nama_kegiatan . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $laporan = $query->orderBy('tanggal', 'desc')->get();

        // Diubah ke folder 'laporan.print'
        $pdf = Pdf::loadView('laporan.print', [
            'laporan'       => $laporan,
            'tanggal_awal'  => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan-Mandalajati.pdf');
    }
}