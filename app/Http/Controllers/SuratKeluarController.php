<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\KodeArsip; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SuratKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = SuratKeluar::with('kodearsip');

        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('nomor_surat', 'like', "%{$keyword}%")
                  ->orWhere('tujuan', 'like', "%{$keyword}%")
                  ->orWhere('perihal', 'like', "%{$keyword}%")
                  ->orWhere('judul', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_surat', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $suratKeluars = $query->latest('tanggal_surat')->paginate(10)->withQueryString();

        return view('suratkeluar.index', compact('suratKeluars'));
    }

    public function create()
    {
        $kodearsip = KodeArsip::all(); 

        return view('suratkeluar.create', compact('kodearsip'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'   => 'required|string|max:255|unique:surat_keluars,nomor_surat',
            'tanggal_surat' => 'required|date',
            'tujuan'        => 'required|string|max:255',
            'judul'         => 'nullable|string|max:255',
            'perihal'       => 'nullable|string',
            'kode_arsip_id' => 'nullable|exists:kode_arsips,id',
            'file_surat'    => 'nullable|file|mimes:pdf|max:5120', 
        ]);

        $filePath = null;
        if ($request->hasFile('file_surat')) {
            $filePath = $request->file('file_surat')->store('surat_keluar', 'public');
        }

        SuratKeluar::create([
            'user_id'       => Auth::id() ?? 1,
            'kode_arsip_id' => $request->kode_arsip_id,
            'nomor_surat'   => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tujuan'        => $request->tujuan,
            'judul'         => $request->judul,
            'perihal'       => $request->perihal,
            'disposisi'     => '-', // Tambahkan baris ini agar tidak error
            'file_surat'    => $filePath,
        ]);

        return redirect()->route('suratkeluar.index')->with('success', 'Data surat keluar berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        $kodearsip = KodeArsip::all(); 
        return view('suratkeluar.edit', compact('suratKeluar', 'kodearsip'));
    }

    public function update(Request $request, $id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);

        $request->validate([
            'nomor_surat'   => 'required|string|max:255|unique:surat_keluars,nomor_surat,' . $id,
            'tanggal_surat' => 'required|date',
            'tujuan'        => 'required|string|max:255',
            'judul'         => 'nullable|string|max:255',
            'perihal'       => 'nullable|string',
            'kode_arsip_id' => 'nullable|exists:kode_arsips,id',
            'file_surat'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ], [
            'file_surat.max' => 'Ukuran berkas file surat tidak boleh lebih dari 5 Megabytes (5MB).',
        ]);

        $filePath = $suratKeluar->file_surat;

        if ($request->hasFile('file_surat')) {
            if ($suratKeluar->file_surat && Storage::disk('public')->exists($suratKeluar->file_surat)) {
                Storage::disk('public')->delete($suratKeluar->file_surat);
            }
            $filePath = $request->file('file_surat')->store('surat_keluar', 'public');
        }

        $suratKeluar->update([
            'user_id'       => Auth::id() ?? 1,
            'kode_arsip_id' => $request->kode_arsip_id,
            'nomor_surat'   => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'tujuan'        => $request->tujuan,
            'judul'         => $request->judul,
            'perihal'       => $request->perihal,
            'disposisi'     => $suratKeluar->disposisi ?? '-', // Tambahkan baris ini
            'file_surat'    => $filePath,
        ]);

        return redirect()->route('suratkeluar.index')->with('success', 'Data surat keluar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);

        if ($suratKeluar->file_surat && Storage::disk('public')->exists($suratKeluar->file_surat)) {
            Storage::disk('public')->delete($suratKeluar->file_surat);
        }

        $suratKeluar->delete();

        return redirect()->route('suratkeluar.index')->with('success', 'Data surat keluar berhasil dihapus!');
    }

    public function getNomorRegistrasi($id)
    {
        $kodeArsip = KodeArsip::find($id);

        if (!$kodeArsip) {
            return response()->json(['nomor_registrasi' => 'Kode tidak ditemukan'], 404);
        }

        $jumlahData = SuratKeluar::count();
        $nomorUrut = $jumlahData + 1; 
        
        $formatNomorUrut = str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

        $bulanRomawi = $this->getBulanRomawi(date('n'));
        $tahun = date('Y');
        
        $nomorRegistrasiReal = "{$formatNomorUrut}/{$kodeArsip->kode}/{$bulanRomawi}/{$tahun}";

        return response()->json([
            'nomor_registrasi' => $nomorRegistrasiReal
        ]);
    }

    private function getBulanRomawi($bulan) 
    {
        $romawi = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        return $romawi[$bulan] ?? '';
    }

    public function disposisi($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        $users = User::all();

        return view('suratkeluar.disposisi', compact('suratKeluar', 'users'));
    }

    public function storeDisposisi(Request $request, $id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);

        $request->validate([
            'user_disposisi_id' => 'required|exists:users,id',
            'catatan_admin'     => 'required|string',
        ]);

        $suratKeluar->update([
            'user_disposisi_id' => $request->user_disposisi_id,
            'catatan_admin'     => $request->catatan_admin,
            'status'            => 'Sudah Disposisi'
        ]);

        return redirect()->route('suratkeluar.index')->with('success', 'Disposisi surat keluar berhasil dikirim!');
    }
    public function show($id)
    {
        $suratkeluar = SuratKeluar::with('kodearsip')->findOrFail($id);
        
        return view('suratkeluar.show', compact('suratkeluar'));
    }
}