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

use Barryvdh\DomPDF\Facade\Pdf;

class SuratMasukController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DATA SURAT MASUK
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $suratmasuk = SuratMasuk::with('kodearsip');

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

        return view('suratmasuk.index', compact('suratmasuk', 'kodearsip'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH SURAT
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $kodearsip = KodeArsip::all();
        return view('suratmasuk.create', compact('kodearsip'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN SURAT MASUK
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | SIMPAN SURAT MASUK
    |--------------------------------------------------------------------------
    |*/
    public function store(Request $request)
    {
        $request->merge([
            'nomor_surat' => trim($request->nomor_surat)
        ]);

        // Rules Validasi Utama
        $rules = [
            'kode_arsip_id'    => 'required|exists:kode_arsips,id',
            'nomor_surat'      => 'required|unique:surat_masuks,nomor_surat',
            'jenis_surat'      => 'required|in:Internal,Eksternal',
            'sumber_arsip'     => 'required',
            'judul'            => 'required|max:255',
            'pengirim'         => 'required|max:255',
            'tanggal_surat'    => 'required|date',
            'perihal'          => 'required',
            'file_surat'       => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        // Validasi bersyarat: Jika Internal, field Agenda/Booking bersifat Wajib (Required)
        if ($request->jenis_surat === 'Internal') {
            $rules['tempat']           = 'required';
            $rules['tanggal_kegiatan'] = 'required|date';
            $rules['jam_mulai']        = 'required';
            $rules['jam_selesai']      = 'required|after:jam_mulai';
            $rules['jumlah_peserta']   = 'nullable|integer';
            $rules['kursi']            = 'nullable|integer';
            $rules['meja']             = 'nullable|integer';
            $rules['proyektor']        = 'nullable|integer';
            $rules['mic']              = 'nullable|integer';
            $rules['sound_system']     = 'nullable|integer';
            $rules['kabel_roll']       = 'nullable|integer';
            $rules['lainnya']          = 'nullable';
        }

        $validatedData = $request->validate($rules);

        // Menggunakan Database Transaction demi keamanan integritas multi-tabel
        DB::beginTransaction();
        try {
            // 1. Generate Nomor Urut dan Nomor Registrasi Otomatis
            $kode = KodeArsip::findOrFail($request->kode_arsip_id);
            $tahun = date('Y');
            $last = SuratMasuk::where('kode_arsip_id', $request->kode_arsip_id)
                ->whereYear('created_at', $tahun)
                ->latest()
                ->first();
                
            $nomorUrut = $last ? $last->nomor_urut + 1 : 1;
            $nomorRegistrasi = "ARSIP/KEC-MND/{$kode->kode}." . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT) . "/{$tahun}";

            // 2. Upload Berkas Surat
            $file = null;
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat')->store('surat_masuk', 'public');
            }

            // 3. Simpan Entri Utama ke Tabel surat_masuks
            $surat = SuratMasuk::create([
                'user_id'           => Auth::id(),
                'kode_arsip_id'     => $request->kode_arsip_id,
                'nomor_urut'        => $nomorUrut,
                
                // HAPUS ATAU KOMENTARI BARIS INI JIKA KOLOMNYA TIDAK ADA DI DB RAILWAY:
                // 'nomor_registrasi'  => $nomorRegistrasi, 
                
                'nomor_surat'       => $request->nomor_surat,
                'jenis_surat'       => $request->jenis_surat,
                'sumber_arsip'      => $request->sumber_arsip,
                'judul'             => $request->judul,
                'pengirim'          => $request->pengirim,
                'tanggal_surat'     => $request->tanggal_surat,
                'perihal'           => $request->perihal,
                'file_surat'        => $file,
                'status'            => 'Belum Disposisi',
            ]);

            // 4. Jika Surat Internal, Simpan Logistik ke Tabel agendas secara otomatis
            if ($request->jenis_surat === 'Internal') {
                Agenda::create([
                    'surat_masuk_id'   => $surat->id,
                    'tempat'           => $request->tempat,
                    'tanggal_kegiatan' => $request->tanggal_kegiatan,
                    'jam_mulai'        => $request->jam_mulai,
                    'jam_selesai'      => $request->jam_selesai,
                    'materi'           => $request->materi ?? $request->judul,
                    'jumlah_peserta'   => $request->jumlah_peserta ?? 0,
                    'kursi'            => $request->kursi ?? 0,
                    'meja'             => $request->meja ?? 0,
                    'proyektor'        => $request->proyektor ?? 0,
                    'mic'              => $request->mic ?? 0,
                    'sound_system'     => $request->sound_system ?? 0,
                    'kabel_roll'       => $request->kabel_roll ?? 0,
                    'lainnya'          => $request->lainnya,
                ]);
            }

            // 5. Integrasikan Arsip Digital secara Otomatis
            // Tetap menggunakan $nomorRegistrasi yang di-generate di atas untuk mencatat nomor arsipnya
            Arsip::create([
                'kode_arsip'    => $nomorRegistrasi,
                'nama_arsip'    => $surat->judul,
                'tanggal_arsip' => $surat->tanggal_surat,
                'kategori'      => 'Surat Masuk',
                'file_arsip'    => $surat->file_surat,
            ]);

            // 6. Kirim Notifikasi Sistem ke Admin
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
            return redirect()->route('suratmasuk.index')->with('success', 'Surat masuk dan data logistik berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memproses arsip: ' . $e->getMessage()]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT SURAT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        // Memuat relasi agenda untuk mengisi field logistik saat form edit dibuka
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
            'kode_arsip_id' => 'required|exists:kode_arsips,id',
            'nomor_surat'   => 'required|unique:surat_masuks,nomor_surat,' . $id,
            'jenis_surat'   => 'required|in:Internal,Eksternal',
            'sumber_arsip'  => 'required',
            'judul'         => 'required|max:255',
            'pengirim'      => 'required|max:255',
            'tanggal_surat' => 'required|date',
            'perihal'       => 'required',
            'file_surat'    => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        if ($request->jenis_surat === 'Internal') {
            $rules['tempat']           = 'required';
            $rules['tanggal_kegiatan'] = 'required|date';
            $rules['jam_mulai']        = 'required';
            $rules['jam_selesai']      = 'required|after:jam_mulai';
        }

        $request->validate($rules);
        $surat = SuratMasuk::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $oldNomorRegistrasi = $surat->nomor_registrasi;
            $tahun = date('Y', strtotime($surat->created_at));

            // Jika Kategori Kode Arsip berubah, hitung ulang nomor registrasi baru
            if ($surat->kode_arsip_id != $request->kode_arsip_id) {
                $kode = KodeArsip::findOrFail($request->kode_arsip_id);
                $last = SuratMasuk::where('kode_arsip_id', $request->kode_arsip_id)
                    ->whereYear('created_at', $tahun)
                    ->latest()
                    ->first();
                $nomorUrut = $last ? $last->nomor_urut + 1 : 1;
                $nomorRegistrasi = "ARSIP/KEC-MND/{$kode->kode}." . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT) . "/{$tahun}";
            } else {
                $nomorUrut = $surat->nomor_urut;
                $nomorRegistrasi = $surat->nomor_registrasi;
            }

            // Ganti berkas fisik jika ada file baru diunggah
            $file = $surat->file_surat;
            if ($request->hasFile('file_surat')) {
                if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                    Storage::disk('public')->delete($surat->file_surat);
                }
                $file = $request->file('file_surat')->store('surat_masuk', 'public');
            }

            // Update Master Surat
            $surat->update([
                'kode_arsip_id'    => $request->kode_arsip_id,
                'nomor_urut'       => $nomorUrut,
                'nomor_registrasi' => $nomorRegistrasi,
                'nomor_surat'      => $request->nomor_surat,
                'jenis_surat'      => $request->jenis_surat,
                'sumber_arsip'     => $request->sumber_arsip,
                'judul'            => $request->judul,
                'pengirim'         => $request->pengirim,
                'tanggal_surat'    => $request->tanggal_surat,
                'perihal'          => $request->perihal,
                'file_surat'       => $file,
            ]);

            // Sinkronisasi Data Agenda / Logistik Internal Mandalaajati
            if ($request->jenis_surat === 'Internal') {
                Agenda::updateOrCreate(
                    ['surat_masuk_id' => $surat->id],
                    [
                        'tempat'           => $request->tempat,
                        'tanggal_kegiatan' => $request->tanggal_kegiatan,
                        'jam_mulai'        => $request->jam_mulai,
                        'jam_selesai'      => $request->jam_selesai,
                        'materi'           => $request->materi ?? $request->judul,
                        'jumlah_peserta'   => $request->jumlah_peserta ?? 0,
                        'kursi'            => $request->kursi ?? 0,
                        'meja'             => $request->meja ?? 0,
                        'proyektor'        => $request->proyektor ?? 0,
                        'mic'              => $request->mic ?? 0,
                        'sound_system'     => $request->sound_system ?? 0,
                        'kabel_roll'       => $request->kabel_roll ?? 0,
                        'lainnya'          => $request->lainnya,
                    ]
                );
            } else {
                // Jika jenis diubah ke Eksternal, hapus rekaman logistik terkait
                Agenda::where('surat_masuk_id', $surat->id)->delete();
            }

            // Update entri data di tabel Arsip Digital
            Arsip::where('kode_arsip', $oldNomorRegistrasi)->update([
                'kode_arsip'    => $nomorRegistrasi,
                'nama_arsip'    => $request->judul,
                'tanggal_arsip' => $request->tanggal_surat,
                'kategori'      => 'Surat Masuk',
                'file_arsip'    => $file,
            ]);

            DB::commit();
            return redirect()->route('suratmasuk.index')->with('success', 'Surat masuk dan data arsip berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS SURAT
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                Storage::disk('public')->delete($surat->file_surat);
            }

            // Hapus rekam jejak di tabel relasi pendukung
            Arsip::where('kode_arsip', $surat->nomor_registrasi)->delete();
            Agenda::where('surat_masuk_id', $surat->id)->delete();
            Notification::where('reference_id', $surat->id)->where('jenis', 'surat')->delete();

            $surat->delete();

            DB::commit();
            return redirect()->route('suratmasuk.index')->with('success', 'Seluruh data berkas dan logistik terkait berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI SURAT
    |--------------------------------------------------------------------------
    */
    public function verifikasi($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $surat->update([
            'status' => 'Belum Disposisi'
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

    /*
    |--------------------------------------------------------------------------
    | PRINT
    |--------------------------------------------------------------------------
    */
    public function print()
    {
        $suratmasuk = SuratMasuk::with([
            'kodearsip',
            'user',
            'userDisposisi'
        ])->latest()->get();

        return view('suratmasuk.print', compact('suratmasuk'));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL SURAT
    |--------------------------------------------------------------------------
    */
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

    /*
    |--------------------------------------------------------------------------
    | HALAMAN DISPOSISI
    |--------------------------------------------------------------------------
    */
    public function disposisi($id)
    {
        $surat = SuratMasuk::with([
            'kodearsip',
            'user',
            'userDisposisi'
        ])->findOrFail($id);

        $users = User::where('role', 'pegawai')
                    ->orderBy('name')
                    ->get();

        return view('suratmasuk.disposisi', compact('surat', 'users'));
    }

    /*
    |--------------------------------------------------------------------------
    | KIRIM DISPOSISI
    |--------------------------------------------------------------------------
    */
    public function kirimDisposisi(Request $request, $id)
    {
        $request->validate([
            'user_disposisi_id' => 'required|exists:users,id',
            'catatan_admin'     => 'required'
        ]);

        $surat = SuratMasuk::findOrFail($id);

        $surat->update([
            'user_disposisi_id' => $request->user_disposisi_id,
            'catatan_admin'     => $request->catatan_admin,
            'status'            => 'Sudah Disposisi'
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

    /*
    |--------------------------------------------------------------------------
    | KIRIM KE AGENDA
    |--------------------------------------------------------------------------
    */
    public function pilihAgenda($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if ($surat->user_disposisi_id != Auth::id()) {
            abort(403);
        }

        $surat->update([
            'status' => 'Sudah Dijadikan Agenda'
        ]);

        return redirect()->route('agenda.create', $surat->id)
                         ->with('success', 'Silakan lengkapi data Agenda.');
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX NOMOR REGISTRASI
    |--------------------------------------------------------------------------
    */
    public function getNomorRegistrasi($id)
    {
        $kode = KodeArsip::findOrFail($id);
        $tahun = date('Y');
        $last = SuratMasuk::where('kode_arsip_id', $id)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->first();
            
        $nomor = $last ? $last->nomor_urut + 1 : 1;
        $nomorLengkap = "ARSIP/KEC-MND/{$kode->kode}." . str_pad($nomor, 3, '0', STR_PAD_LEFT) . "/{$tahun}";

        return response()->json([
            'nomor_registrasi' => $nomorLengkap
        ]);
    }
}