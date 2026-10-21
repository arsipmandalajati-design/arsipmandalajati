<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arsip;
use App\Models\KodeArsip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
        // PERBAIKAN: Gunakan Model Arsip, bukan KodeArsip
        $query = Arsip::query();

        if ($request->filled('nomor_registrasi')) {
            $query->where(
                'nomor_registrasi',
                'LIKE',
                '%' . $request->nomor_registrasi . '%'
            );
        }

        if ($request->filled('nama_arsip')) {
            $query->where(
                'nama_arsip',
                'LIKE',
                '%' . $request->nama_arsip . '%'
            );
        }

        $arsip = $query->latest()->paginate(10);

        return view(
            'arsip.index',
            compact('arsip')
        );
    }

    public function create()
    {
        $kodearsip = KodeArsip::all();

        return view(
            'arsip.create',
            compact('kodearsip')
        );
    }

    public function edit($id)
{
    // Mengambil data arsip berdasarkan ID
    $arsip = Arsip::findOrFail($id);

    // Menampilkan view edit dengan membawa data arsip
    return view('arsip.edit', compact('arsip'));
}
    /*
    |--------------------------------------------------------------------------
    | Generate Nomor Registrasi
    |--------------------------------------------------------------------------
    */

    public function getNomorRegistrasi($id)
    {
        $kodeArsip = KodeArsip::find($id);

        if (!$kodeArsip) {
            return response()->json([
                'nomor_registrasi' => ''
            ]);
        }

        $count = Arsip::where(
            'kode_arsip',
            $kodeArsip->kode
        )->count() + 1;

        $nomorUrut = sprintf('%03d', $count);

        $tahun = date('Y');

        $nomorRegistrasi =
            $kodeArsip->kode .
            ' / ' .
            $nomorUrut .
            ' / ' .
            $tahun;

        return response()->json([
            'nomor_registrasi' => $nomorRegistrasi
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Arsip
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'kode_arsip'       => 'required',
            'nomor_registrasi' => 'required',
            'nama_arsip'       => 'required',
            'tanggal_arsip'    => 'required|date',
            'retensi_tahun'    => 'required|integer',
            'file_arsip'       => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $kode = KodeArsip::findOrFail($request->kode_arsip);

        $file = $request
            ->file('file_arsip')
            ->store('arsip', 'public');

        $retensi = (int) $request->retensi_tahun;

        $tanggalKadaluarsa = Carbon::parse(
            $request->tanggal_arsip
        )->addYears($retensi);

        Arsip::create([
            'kode_arsip' => $kode->kode,
            'nomor_registrasi' => $request->nomor_registrasi,
            'nama_arsip' => $request->nama_arsip,
            'tanggal_arsip' => $request->tanggal_arsip,
            'retensi_tahun' => $retensi,
            'tanggal_kadaluarsa' => $tanggalKadaluarsa->format('Y-m-d'),
            'file_arsip' => $file,
        ]);

        return redirect()
            ->route('arsip.index')
            ->with(
                'success',
                'Data arsip berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Update Arsip
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
{
    $arsip = Arsip::findOrFail($id);

    // Validasi input
    $request->validate([
        'kode_arsip' => 'required|string|max:255',
        'nama_arsip' => 'required|string',
        'retensi_tahun' => 'required|integer',
        'file_arsip' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
    ]);

    // Handle upload file baru jika ada
    if ($request->hasFile('file_arsip')) {
        // Hapus file lama jika perlu, lalu simpan yang baru
        // (Opsional sesuai logika penyimpanan file Anda)
        $filePath = $request->file('file_arsip')->store('arsip', 'public');
        $arsip->file_arsip = $filePath;
    }

    // Update data lainnya
    $arsip->kode_arsip = $request->kode_arsip;
    $arsip->nama_arsip = $request->nama_arsip;
    $arsip->retensi_tahun = $request->retensi_tahun;
    $arsip->save();

    return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil diperbarui!');
}

    /*
    |--------------------------------------------------------------------------
    | Hapus Arsip
    |--------------------------------------------------------------------------
    */

    public function destroy(Arsip $arsip)
    {
        // Hapus file fisik dari storage
        if ($arsip->file_arsip && Storage::disk('public')->exists($arsip->file_arsip)) {
            Storage::disk('public')->delete($arsip->file_arsip);
        }

        $arsip->delete();

        return redirect()
            ->route('arsip.index')
            ->with(
                'success',
                'Data arsip berhasil dihapus.'
            );
    }

    public function print(Request $request)
{
    $arsip = Arsip::latest()->get();
    return view('arsip.print', compact('arsip'));
}

}