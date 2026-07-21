<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\SuratKeluar;
use App\Models\Arsip;
use App\Models\KodeArsip;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratKeluarController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DATA SURAT KELUAR
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $kodearsip = KodeArsip::orderBy('kode')->get();
        $query = SuratKeluar::with('kodearsip');

        // Filter Kode Arsip
        if ($request->filled('kode_arsip_id')) {
            $query->where('kode_arsip_id', $request->kode_arsip_id);
        }

        // Filter Pengirim
        if ($request->filled('pengirim')) {
            $query->where('pengirim', 'LIKE', '%' . $request->pengirim . '%');
        }

        // Filter Tujuan
        if ($request->filled('tujuan')) {
            $query->where('tujuan', 'LIKE', '%' . $request->tujuan . '%');
        }

        // Filter Perihal
        if ($request->filled('perihal')) {
            $query->where('perihal', 'LIKE', '%' . $request->perihal . '%');
        }

        // Filter Tanggal
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_surat', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_surat', '<=', $request->tanggal_akhir);
        }

        $suratkeluar = $query->latest()->get();

        return view('suratkeluar.index', compact('suratkeluar', 'kodearsip'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH SURAT
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $kodearsip = KodeArsip::orderBy('kode')->get();
        return view('suratkeluar.create', compact('kodearsip'));
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO GENERATE NOMOR REGISTRASI (Berdasarkan Kode Arsip)
    |--------------------------------------------------------------------------
    */
    public function generateNomorRegistrasi(Request $request)
    {
        $kodeArsipId = $request->kode_arsip_id;
        $kodeArsip = KodeArsip::find($kodeArsipId);

        if (!$kodeArsip) {
            return response()->json(['nomor_registrasi' => '']);
        }

        // Cari urutan surat keluar terakhir berdasarkan kode arsip tersebut
        $lastSurat = SuratKeluar::where('kode_arsip_id', $kodeArsipId)
            ->latest('id')
            ->first();

        $nextNumber = 1;
        if ($lastSurat && preg_match('/\/(\d+)\//', $lastSurat->nomor_surat, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            // Jika tidak ada format khusus, hitung jumlah data + 1
            $nextNumber = SuratKeluar::where('kode_arsip_id', $kodeArsipId)->count() + 1;
        }

        $nomorUrutPadded = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $bulanRomawi = $this->getBulanRomawi(date('n'));
        $tahun = date('Y');

        // Format: [Nomer Urut]/[Kode Arsip]/[Bulan]/[Tahun]
        $nomorRegistrasiOtomatis = "{$nomorUrutPadded}/SK-{$kodeArsip->kode}/{$bulanRomawi}/{$tahun}";

        return response()->json(['nomor_registrasi' => $nomorRegistrasiOtomatis]);
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN SURAT KELUAR
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'kode_arsip_id' => 'required|exists:kode_arsip,id',
            'nomor_surat'   => 'required|string',
            'judul'         => 'required|string|max:255',
            'pengirim'      => 'required|string',
            'tujuan'        => 'required|string',
            'tanggal_surat' => 'required|date',
            'perihal'       => 'required|string',
            'disposisi'     => 'nullable|string',
            'file_surat'    => 'required|mimes:pdf|max:2048',
        ]);

        $file = null;
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat')->store('surat_keluar', 'public');
        }

        $surat = SuratKeluar::create([
            'user_id'       => Auth::id(),
            'kode_arsip_id' => $request->kode_arsip_id,
            'nomor_surat'   => $request->nomor_surat,
            'judul'         => $request->judul,
            'pengirim'      => $request->pengirim,
            'tujuan'        => $request->tujuan,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal'       => $request->perihal,
            'disposisi'     => $request->disposisi ?? 'Menunggu ACC',
            'file_surat'    => $file,
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE TABEL ARSIP (+ Hitung Kadaluarsa)
        |--------------------------------------------------------------------------
        */
        $tanggalKadaluarsa = Carbon::parse($request->tanggal_surat)->addYears(2)->toDateString();

        Arsip::create([
            'kode_arsip'         => $surat->kodearsip->kode ?? '-',
            'nama_arsip'         => $surat->judul,
            'tanggal_arsip'      => $surat->tanggal_surat,
            'tanggal_kadaluarsa' => $tanggalKadaluarsa, // Fitur Baru Kadaluarsa
            'kategori'           => 'Surat Keluar',
            'file_arsip'         => $surat->file_surat,
        ]);

        return redirect()
            ->route('suratkeluar.index')
            ->with('success', 'Data surat keluar berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(SuratKeluar $suratkeluar)
    {
        $kodearsip = KodeArsip::orderBy('kode')->get();
        return view('suratkeluar.edit', [
            'surat'     => $suratkeluar,
            'kodearsip' => $kodearsip
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, SuratKeluar $suratkeluar)
    {
        $request->validate([
            'kode_arsip_id' => 'required|exists:kode_arsip,id',
            'nomor_surat'   => 'required|string',
            'judul'         => 'required|string|max:255',
            'pengirim'      => 'required|string',
            'tujuan'        => 'required|string',
            'tanggal_surat' => 'required|date',
            'perihal'       => 'required|string',
            'disposisi'     => 'nullable|string',
            'file_surat'    => 'nullable|mimes:pdf|max:2048',
        ]);

        $file = $suratkeluar->file_surat;
        $oldFileSurat = $suratkeluar->file_surat;

        if ($request->hasFile('file_surat')) {
            if ($suratkeluar->file_surat && Storage::disk('public')->exists($suratkeluar->file_surat)) {
                Storage::disk('public')->delete($suratkeluar->file_surat);
            }
            $file = $request->file('file_surat')->store('surat_keluar', 'public');
        }

        $suratkeluar->update([
            'kode_arsip_id' => $request->kode_arsip_id,
            'nomor_surat'   => $request->nomor_surat,
            'judul'         => $request->judul,
            'pengirim'      => $request->pengirim,
            'tujuan'        => $request->tujuan,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal'       => $request->perihal,
            'disposisi'     => $request->disposisi,
            'file_surat'    => $file,
        ]);

        // Update Data Arsip
        $tanggalKadaluarsa = Carbon::parse($request->tanggal_surat)->addYears(2)->toDateString();

        Arsip::where('file_arsip', $oldFileSurat)->update([
            'kode_arsip'         => $suratkeluar->kodearsip->kode ?? '-',
            'nama_arsip'         => $request->judul,
            'tanggal_arsip'      => $request->tanggal_surat,
            'tanggal_kadaluarsa' => $tanggalKadaluarsa,
            'kategori'           => 'Surat Keluar',
            'file_arsip'         => $file,
        ]);

        return redirect()
            ->route('suratkeluar.index')
            ->with('success', 'Data surat keluar berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA
    |--------------------------------------------------------------------------
    */
    public function destroy(SuratKeluar $suratkeluar)
    {
        if ($suratkeluar->file_surat && Storage::disk('public')->exists($suratkeluar->file_surat)) {
            Storage::disk('public')->delete($suratkeluar->file_surat);
        }

        Arsip::where('file_arsip', $suratkeluar->file_surat)->delete();
        $suratkeluar->delete();

        return redirect()
            ->route('suratkeluar.index')
            ->with('success', 'Data surat keluar berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL SURAT (Response JSON untuk Modal Preview / Visual Sejajar)
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $suratkeluar = SuratKeluar::with('kodearsip')->findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data'   => $suratkeluar,
                'file_url' => asset('storage/' . $suratkeluar->file_surat)
            ]);
        }

        return view('suratkeluar.show', compact('suratkeluar'));
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: KONVERSI BULAN KE ROMAWI
    |--------------------------------------------------------------------------
    */
    private function getBulanRomawi($bulan)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
            11 => 'XI', 12 => 'XII'
        ];
        return $map[$bulan] ?? 'I';
    }
}