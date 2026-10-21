<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\Agenda;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Arsip;
use App\Models\KodeArsip;
use App\Models\Notification;
use App\Models\User;
use App\Models\Ruangan;

class SuratMasukController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HELPER: REUSABLE LOGIC NOMOR REGISTRASI
    |--------------------------------------------------------------------------
    */
    private function generateNomorRegistrasi($kodeArsipId, $tahun = null, $nomorUrutExist = null)
    {
        $kodeArsip = KodeArsip::findOrFail($kodeArsipId);
        $tahun = $tahun ?? date('Y');

        if (!$nomorUrutExist) {
            $lastNomorUrut = SuratMasuk::where('kode_arsip_id', $kodeArsipId)
                ->whereYear('created_at', $tahun)
                ->max('nomor_urut');

            $nomorUrutInt = $lastNomorUrut ? $lastNomorUrut + 1 : 1;
        } else {
            $nomorUrutInt = $nomorUrutExist;
        }

        $kode = $kodeArsip->kode ?? $kodeArsip->kode_arsip ?? '00.00';
        $nomorUrut = str_pad($nomorUrutInt, 3, '0', STR_PAD_LEFT);
        $kodeUnit = $kodeArsip->kode_unit ?? 'Subbag.Umum';

        $arrayRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bulanRomawi = $arrayRomawi[(int)date('n')];

        $nomorRegistrasi = "No." . $kode . "/" . $nomorUrut . "-" . $kodeUnit . "-Kec.MDLJ/T/" . $bulanRomawi . "/" . $tahun;

        return [
            'nomor_urut'       => $nomorUrutInt,
            'nomor_registrasi' => $nomorRegistrasi
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | DATA SURAT MASUK
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $suratmasuk = SuratMasuk::with(['kodearsip', 'userDisposisi']);

        if ($request->filled('tanggal_awal')) {
            $suratmasuk->whereDate('tanggal_surat', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $suratmasuk->whereDate('tanggal_surat', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('kode_arsip')) {
            $suratmasuk->whereHas('kodearsip', function ($q) use ($request) {
                $q->where('kode', 'LIKE', '%' . $request->kode_arsip . '%');
            });
        }

        if ($request->filled('perihal')) {
            $suratmasuk->where('perihal', 'LIKE', '%' . $request->perihal . '%');
        }

        if ($request->filled('status')) {
            $suratmasuk->where('status', $request->status);
        }

        $suratmasuk = $suratmasuk->latest()->get();
        $kodearsip = KodeArsip::all();
        
        // AMBIL DATA USER/PEGAWAI DENGAN VARIABEL $users
        $users = User::orderBy('name')->get(); 

        return view('suratmasuk.index', compact('suratmasuk', 'kodearsip', 'users'));
    }

    public function create()
{
    // Ambil data kode arsip dan data ruangan dari database
    $kodearsip = KodeArsip::all();
    $daftar_ruangan = Ruangan::all(); 

    // Kirim kedua variabel tersebut ke view suratmasuk.create
    return view('suratmasuk.create', compact('kodearsip', 'daftar_ruangan'));
}
    /*
    |--------------------------------------------------------------------------
    | SIMPAN SURAT MASUK
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->merge([
            'nomor_surat' => trim($request->nomor_surat)
        ]);

        $rules = [
            'kode_arsip_id'      => 'required|exists:kode_arsips,id',
            'nomor_surat'        => 'required|unique:surat_masuks,nomor_surat',
            'jenis_surat'        => 'required|in:Internal,Eksternal',
            'judul'              => 'required|max:255',
            'pengirim'           => 'required|max:255',
            'tanggal_surat'      => 'required|date',
            'tanggal_diterima'   => 'nullable|date',
            'tanggal_kadaluarsa' => 'nullable|date',
            'perihal'            => 'required',
            'file_surat'         => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        if ($request->jenis_surat === 'Internal') {
            $rules['tempat']           = 'nullable|string';
            $rules['tanggal_kegiatan'] = 'required_with:tempat|date';
            $rules['jam_mulai']        = 'required_with:tempat';
            $rules['jam_selesai']      = 'required_with:tempat|after:jam_mulai';
        
            $rules['jumlah_peserta']   = 'nullable|numeric|min:0';
            $rules['kursi']            = 'nullable|numeric|min:0';
            $rules['meja']             = 'nullable|numeric|min:0';
            $rules['proyektor']        = 'nullable|numeric|min:0';
            $rules['mic']              = 'nullable|numeric|min:0';
            $rules['sound_system']     = 'nullable|numeric|min:0';
            $rules['kabel_roll']       = 'nullable|numeric|min:0';
            $rules['lainnya']          = 'nullable|string|max:255';
        }

        $request->validate($rules);

        // =========================================================================
        // CEK BENTROK JADWAL RUANGAN (BOOKING CHECK)
        // =========================================================================
        if ($request->jenis_surat === 'Internal' && $request->filled('tempat') && $request->filled('tanggal_kegiatan')) {
            $isBentrok = Agenda::where('tempat', $request->tempat)
                ->whereDate('tanggal', $request->tanggal_kegiatan)
                ->where(function ($query) use ($request) {
                    $query->where('jam_mulai', '<', $request->jam_selesai)
                          ->where('jam_selesai', '>', $request->jam_mulai);
                })
                ->exists();

            if ($isBentrok) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'tempat' => '⚠️ RUANGAN SUDAH DIPAKAI! Ruangan "' . $request->tempat . '" sudah terpesan pada tanggal ' . date('d-m-Y', strtotime($request->tanggal_kegiatan)) . ' jam ' . $request->jam_mulai . ' s/d ' . $request->jam_selesai . '. Silakan pilih waktu atau ruangan lain.'
                    ]);
            }
        }
        // =========================================================================

        DB::beginTransaction();
        try {
            $regData = $this->generateNomorRegistrasi($request->kode_arsip_id);
            $nomorUrut = $regData['nomor_urut'];
            $nomorRegistrasi = $regData['nomor_registrasi'];

            $file = null;
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat')->store('surat_masuk', 'public');
            }

            $surat = SuratMasuk::create([
                'user_id'            => Auth::id(),
                'kode_arsip_id'      => $request->kode_arsip_id,
                'nomor_urut'         => $nomorUrut,
                'nomor_registrasi'   => $nomorRegistrasi, 
                'nomor_surat'        => $request->nomor_surat,
                'no_surat_asal'      => $request->no_surat_asal ?? $request->nomor_surat,
                'jenis_surat'        => $request->jenis_surat,
                'judul'              => $request->judul,
                'pengirim'           => $request->pengirim,
                'tanggal_surat'      => $request->tanggal_surat,
                'tanggal_diterima'   => $request->tanggal_diterima ?? date('Y-m-d'),
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'perihal'            => $request->perihal,
                'file_surat'         => $file,
                'status'             => 'Belum Disposisi',
                'status_acc'         => 'pending',
            ]);

            if ($request->jenis_surat === 'Internal' && $request->filled('tempat')) {
                Agenda::create([
                    'surat_masuk_id' => $surat->id,
                    'user_id'        => Auth::id(),
                    'nama_kegiatan'  => $surat->judul,
                    'tanggal'        => $request->tanggal_kegiatan ?? $surat->tanggal_surat,
                    'penyelenggara'  => $surat->pengirim,
                    'keterangan'     => $surat->perihal,
                    'tempat'         => $request->tempat,
                    'status'         => 'Terjadwal',
                    'jam_mulai'      => $request->jam_mulai,
                    'jam_selesai'    => $request->jam_selesai,
                    'materi'         => $request->materi ?? $surat->judul,
                    
                    'jumlah_peserta' => $request->jumlah_peserta ?? 0,
                    'kursi'          => $request->kursi ?? 0,
                    'meja'           => $request->meja ?? 0,
                    'proyektor'      => $request->proyektor ?? 0,
                    'mic'            => $request->mic ?? 0,
                    'sound_system'   => $request->sound_system ?? 0,
                    'kabel_roll'     => $request->kabel_roll ?? 0,
                    'lainnya'        => $request->lainnya ?? null,
                ]);
            }

            Arsip::create([
                'kode_arsip'       => $nomorRegistrasi,
                'nomor_registrasi' => $nomorRegistrasi,
                'nama_arsip'       => $surat->judul,
                'tanggal_arsip'    => $surat->tanggal_surat,
                'kategori'         => 'Surat Masuk',
                'file_arsip'       => $surat->file_surat,
            ]);

            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'      => $admin->id,
                    'judul'        => 'Surat Masuk Baru',
                    'pesan'        => Auth::user()->name . ' menambahkan surat "' . $surat->judul . '".',
                    'jenis'        => 'surat',
                    'reference_id' => $surat->id,
                    'is_read'      => 0,
                ]);
            }

            DB::commit();
            return redirect()->route('suratmasuk.index')->with('success', 'Surat masuk berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memproses arsip: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $surat = SuratMasuk::with('agenda')->findOrFail($id);
        $kodearsip = KodeArsip::all();

        return view('suratmasuk.edit', compact('surat', 'kodearsip'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SURAT MASUK
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->merge([
            'nomor_surat' => trim($request->nomor_surat)
        ]);

        $rules = [
            'kode_arsip_id'      => 'required|exists:kode_arsips,id',
            'nomor_surat'        => 'required|unique:surat_masuks,nomor_surat,' . $id,
            'jenis_surat'        => 'required|in:Internal,Eksternal',
            'judul'              => 'required|max:255',
            'pengirim'           => 'required|max:255',
            'tanggal_surat'      => 'required|date',
            'tanggal_diterima'   => 'nullable|date',
            'tanggal_kadaluarsa' => 'nullable|date',
            'perihal'            => 'required',
            'file_surat'         => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        if ($request->jenis_surat === 'Internal') {
            $rules['tempat']           = 'nullable|string';
            $rules['tanggal_kegiatan'] = 'required_with:tempat|date';
            $rules['jam_mulai']        = 'required_with:tempat';
            $rules['jam_selesai']      = 'required_with:tempat|after:jam_mulai';
        
            $rules['jumlah_peserta']   = 'nullable|numeric|min:0';
            $rules['kursi']            = 'nullable|numeric|min:0';
            $rules['meja']             = 'nullable|numeric|min:0';
            $rules['proyektor']        = 'nullable|numeric|min:0';
            $rules['mic']              = 'nullable|numeric|min:0';
            $rules['sound_system']     = 'nullable|numeric|min:0';
            $rules['kabel_roll']       = 'nullable|numeric|min:0';
            $rules['lainnya']          = 'nullable|string|max:255';
        }

        $request->validate($rules);

        // =========================================================================
        // CEK BENTROK JADWAL RUANGAN SAAT UPDATE
        // =========================================================================
        if ($request->jenis_surat === 'Internal' && $request->filled('tempat') && $request->filled('tanggal_kegiatan')) {
            $isBentrok = Agenda::where('tempat', $request->tempat)
                ->whereDate('tanggal', $request->tanggal_kegiatan)
                ->where('surat_masuk_id', '!=', $id)
                ->where(function ($query) use ($request) {
                    $query->where('jam_mulai', '<', $request->jam_selesai)
                          ->where('jam_selesai', '>', $request->jam_mulai);
                })
                ->exists();

            if ($isBentrok) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'tempat' => '⚠️ RUANGAN SUDAH DIPAKAI! Ruangan "' . $request->tempat . '" sudah terpesan pada tanggal ' . date('d-m-Y', strtotime($request->tanggal_kegiatan)) . ' jam ' . $request->jam_mulai . ' s/d ' . $request->jam_selesai . '.'
                    ]);
            }
        }
        // =========================================================================

        $surat = SuratMasuk::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $oldNomorRegistrasi = $surat->nomor_registrasi;
            $tahun = date('Y', strtotime($surat->created_at));

            if ($surat->kode_arsip_id != $request->kode_arsip_id) {
                $regData = $this->generateNomorRegistrasi($request->kode_arsip_id, $tahun);
                $nomorUrut = $regData['nomor_urut'];
                $nomorRegistrasi = $regData['nomor_registrasi'];
            } else {
                $nomorUrut = $surat->nomor_urut;
                $nomorRegistrasi = $surat->nomor_registrasi;
            }

            $file = $surat->file_surat;
            if ($request->hasFile('file_surat')) {
                if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                    Storage::disk('public')->delete($surat->file_surat);
                }
                $file = $request->file('file_surat')->store('surat_masuk', 'public');
            }

            $surat->update([
                'kode_arsip_id'      => $request->kode_arsip_id,
                'nomor_urut'         => $nomorUrut,
                'nomor_registrasi'   => $nomorRegistrasi,
                'nomor_surat'        => $request->nomor_surat,
                'no_surat_asal'      => $request->no_surat_asal ?? $request->nomor_surat,
                'jenis_surat'        => $request->jenis_surat,
                'judul'              => $request->judul,
                'pengirim'           => $request->pengirim,
                'tanggal_surat'      => $request->tanggal_surat,
                'tanggal_diterima'   => $request->tanggal_diterima,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'perihal'            => $request->perihal,
                'file_surat'         => $file,
            ]);

            if ($request->jenis_surat === 'Internal' && $request->filled('tempat')) {
                Agenda::updateOrCreate(
                    ['surat_masuk_id' => $surat->id],
                    [
                        'user_id'          => Auth::id(),
                        'nama_kegiatan'    => $surat->judul,
                        'penyelenggara'    => $surat->pengirim,
                        'keterangan'       => $surat->perihal,
                        'tempat'           => $request->tempat,
                        'tanggal'          => $request->tanggal_kegiatan ?? $surat->tanggal_surat,
                        'jam_mulai'        => $request->jam_mulai,
                        'jam_selesai'      => $request->jam_selesai,
                        'materi'           => $request->materi ?? $surat->judul,
                        'jumlah_peserta'   => $request->jumlah_peserta ?? 0,
                        'kursi'            => $request->kursi ?? 0,
                        'meja'             => $request->meja ?? 0,
                        'proyektor'        => $request->proyektor ?? 0,
                        'mic'              => $request->mic ?? 0,
                        'sound_system'     => $request->sound_system ?? 0,
                        'kabel_roll'       => $request->kabel_roll ?? 0,
                        'lainnya'          => $request->lainnya ?? null,
                    ]
                );
            } else {
                Agenda::where('surat_masuk_id', $surat->id)->delete();
            }

            Arsip::where('kode_arsip', $oldNomorRegistrasi)->update([
                'kode_arsip'       => $nomorRegistrasi,
                'nomor_registrasi' => $nomorRegistrasi,
                'nama_arsip'       => $request->judul,
                'tanggal_arsip'    => $request->tanggal_surat,
                'kategori'         => 'Surat Masuk',
                'file_arsip'       => $file,
            ]);

            DB::commit();
            return redirect()->route('suratmasuk.index')->with('success', 'Surat masuk berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
{
    // Hanya admin yang boleh menghapus
    if (strtolower(trim(Auth::user()->role)) !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $surat = SuratMasuk::findOrFail($id);

    DB::beginTransaction();

    try {

        // Hapus file surat
        if (
            $surat->file_surat &&
            Storage::disk('public')->exists($surat->file_surat)
        ) {
            Storage::disk('public')->delete($surat->file_surat);
        }

        // Hapus arsip yang terkait
        Arsip::where(
            'kode_arsip',
            $surat->nomor_registrasi
        )->delete();

        // Hapus agenda yang terkait
        Agenda::where(
            'surat_masuk_id',
            $surat->id
        )->delete();

        // Hapus notifikasi
        Notification::where(
            'reference_id',
            $surat->id
        )
        ->where(
            'jenis',
            'surat'
        )
        ->delete();

        // Hapus surat masuk
        $surat->delete();

        DB::commit();

        return redirect()
            ->route('suratmasuk.index')
            ->with(
                'success',
                'Surat masuk dan seluruh data terkait berhasil dihapus.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return redirect()
            ->back()
            ->with(
                'error',
                'Gagal menghapus data: ' . $e->getMessage()
            );
    }
}

    public function verifikasi($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $surat->update([
            'status'     => 'Belum Disposisi',
            'status_acc' => 'approved'
        ]);

        Notification::create([
            'user_id'      => $surat->user_id,
            'judul'        => 'Surat Diverifikasi',
            'pesan'        => 'Surat "' . $surat->judul . '" berhasil diverifikasi Admin.',
            'jenis'        => 'surat',
            'reference_id' => $surat->id,
            'is_read'      => 0,
        ]);

        return redirect()->route('suratmasuk.index')->with('success', 'Surat berhasil diverifikasi.');
    }

    public function print()
    {
        $suratmasuk = SuratMasuk::with([
            'kodearsip',
            'user',
            'userDisposisi'
        ])->latest()->get();

        return view('suratmasuk.print', compact('suratmasuk'));
    }

    public function show($id)
    {
        $suratmasuk = SuratMasuk::with([
            'kodearsip',
            'user',
            'userDisposisi',
            'agenda'
        ])->findOrFail($id);

        return view('suratmasuk.show', compact('suratmasuk'));
    }

    public function preview($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if (!$surat->file_surat || !Storage::disk('public')->exists($surat->file_surat)) {
            return response()->json(['error' => 'File tidak ditemukan.'], 404);
        }

        return response()->json([
            'file_url' => asset('storage/' . $surat->file_surat),
            'judul'    => $surat->judul
        ]);
    }

    public function disposisi($id)
    {
        $surat = SuratMasuk::with([
            'kodearsip',
            'user',
            'userDisposisi'
        ])->findOrFail($id);

        $users = User::orderBy('name')->get();

        return view('suratmasuk.disposisi', compact('surat', 'users'));
    }

    public function kirimDisposisi(Request $request, $id)
    {
        $request->validate([
            'user_disposisi_id'   => 'required|exists:users,id',
            'catatan_admin'       => 'required',
            'tgl_batas_disposisi' => 'nullable|date'
        ]);

        $surat = SuratMasuk::findOrFail($id);

        $surat->update([
            'user_disposisi_id'   => $request->user_disposisi_id,
            'catatan_admin'       => $request->catatan_admin,
            'tgl_batas_disposisi' => $request->tgl_batas_disposisi,
            'status'              => 'Sudah Disposisi'
        ]);

        Notification::create([
            'user_id'      => $request->user_disposisi_id,
            'judul'        => 'Disposisi Baru',
            'pesan'        => 'Anda menerima disposisi surat "' . $surat->judul . '".',
            'jenis'        => 'surat',
            'reference_id' => $surat->id,
            'is_read'      => 0
        ]);

        return redirect()->route('suratmasuk.index')->with('success', 'Disposisi berhasil dikirim.');
    }

    public function pilihAgenda($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if ($surat->user_disposisi_id != Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $surat->update([
            'status' => 'Sudah Dijadikan Agenda'
        ]);

        return redirect()->route('agenda.create', $surat->id)
                         ->with('success', 'Silakan lengkapi data Agenda.');
    }

    public function getNomorRegistrasi($id)
    {
        try {
            $regData = $this->generateNomorRegistrasi($id);

            return response()->json([
                'nomor_registrasi' => $regData['nomor_registrasi']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getLastNomor(Request $request)
    {
        $kasi = $request->get('kasi');
        $tahun = date('Y');

        $lastSurat = SuratMasuk::where('jenis_surat', 'Internal')
            ->where('pengirim', 'LIKE', "%{$kasi}%")
            ->whereYear('created_at', $tahun)
            ->latest()
            ->first();

        if ($lastSurat) {
            $lastNomorFull = $lastSurat->nomor_surat;
            
            $parts = explode('/', $lastNomorFull);
            $lastNumberInt = isset($parts[0]) ? (int) $parts[0] : 0;
            
            $nextNumberInt = $lastNumberInt + 1;
            $nextNumberPadded = str_pad($nextNumberInt, 3, '0', STR_PAD_LEFT);
        } else {
            $lastNomorFull = 'Belum ada surat';
            $nextNumberPadded = '001';
        }

        return response()->json([
            'last_full_nomor' => $lastNomorFull,
            'next_number'     => $nextNumberPadded
        ]);
    }

    public function storeRuanganAjax(Request $request)
{
    try {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'status'       => 'required|in:tersedia,renovasi',
        ]);

        // Gunakan updateOrCreate: Cari berdasarkan nama_ruangan, update/buat statusnya
        $ruangan = Ruangan::updateOrCreate(
            ['nama_ruangan' => $request->nama_ruangan], // Kunci pencarian
            ['status'       => $request->status]        // Data yang diupdate/diisi
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Status ruangan berhasil diperbarui!',
            'data'    => $ruangan
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

}