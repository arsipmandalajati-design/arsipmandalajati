<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request)
    {
        $request->merge([
            'nomor_surat' => trim($request->nomor_surat)
        ]);

        $request->validate([
            'kode_arsip_id'    => 'required|exists:kode_arsips,id',
            'nomor_surat'      => 'required|unique:surat_masuks,nomor_surat',
            'jenis_surat'      => 'required',
            'sumber_arsip'     => 'required',
            'judul'            => 'required',
            'pengirim'         => 'required',
            'tanggal_surat'    => 'required|date',
            'perihal'          => 'required',
            'file_surat'       => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'tempat'           => 'nullable',
            'tanggal_kegiatan' => 'nullable|date',
            'jam_mulai'        => 'nullable',
            'jam_selesai'      => 'nullable',
            'materi'           => 'nullable',
            'jumlah_peserta'   => 'nullable|integer',
            'kursi'            => 'nullable|integer',
            'meja'             => 'nullable|integer',
            'proyektor'        => 'nullable|integer',
            'mic'              => 'nullable|integer',
            'sound_system'     => 'nullable|integer',
            'kabel_roll'       => 'nullable|integer',
            'lainnya'          => 'nullable',
        ]);

        $kode = KodeArsip::findOrFail($request->kode_arsip_id);
        $last = SuratMasuk::where('kode_arsip_id', $request->kode_arsip_id)->latest()->first();
        $nomorUrut = $last ? $last->nomor_urut + 1 : 1;
        $nomorRegistrasi = $kode->kode . '/' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

        $file = null;
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat')->store('surat_masuk', 'public');
        }

        $surat = SuratMasuk::create([
            'user_id'           => Auth::id(),
            'kode_arsip_id'     => $request->kode_arsip_id,
            'nomor_urut'        => $nomorUrut,
           // 'nomor_registrasi'  => $nomorRegistrasi,//
            'nomor_surat'       => $request->nomor_surat,
            'jenis_surat'       => $request->jenis_surat,
            'sumber_arsip'      => $request->sumber_arsip,
            'judul'             => $request->judul,
            'pengirim'          => $request->pengirim,
            'tanggal_surat'     => $request->tanggal_surat,
            'perihal'           => $request->perihal,
            'file_surat'        => $file,
            'tempat'            => $request->tempat,
            'tanggal_kegiatan'  => $request->tanggal_kegiatan,
            'jam_mulai'         => $request->jam_mulai,
            'jam_selesai'       => $request->jam_selesai,
            'materi'            => $request->materi,
            'jumlah_peserta'    => $request->jumlah_peserta ?? 0,
            'kursi'             => $request->kursi ?? 0,
            'meja'              => $request->meja ?? 0,
            'proyektor'         => $request->proyektor ?? 0,
            'mic'               => $request->mic ?? 0,
            'sound_system'      => $request->sound_system ?? 0,
            'kabel_roll'        => $request->kabel_roll ?? 0,
            'lainnya'           => $request->lainnya,
            'status'            => 'Belum Disposisi',
        ]);

        // Simpan ke Tabel Arsip Global
        Arsip::create([
            'kode_arsip'    => $nomorRegistrasi,
            'nama_arsip'    => $surat->judul,
            'tanggal_arsip' => $surat->tanggal_surat,
            'kategori'      => 'Surat Masuk',
            'file_arsip'    => $surat->file_surat,
        ]);

        // Kirim Notifikasi ke Admin
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

        return redirect()->route('suratmasuk.index')->with('success', 'Surat masuk berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT SURAT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $surat = SuratMasuk::findOrFail($id);
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

        $request->validate([
            'kode_arsip_id' => 'required|exists:kode_arsips,id',
            'nomor_surat'   => 'required|unique:surat_masuks,nomor_surat,' . $id,
            'jenis_surat'   => 'required',
            'sumber_arsip'  => 'required',
            'judul'         => 'required',
            'pengirim'      => 'required',
            'tanggal_surat' => 'required|date',
            'perihal'       => 'required',
            'file_surat'    => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $surat = SuratMasuk::findOrFail($id);
        
        // Simpan nomor registrasi lama untuk acuan update tabel Arsip nanti
        $oldNomorRegistrasi = $surat->nomor_registrasi;

        // Jika kode arsip diubah, generate nomor registrasi baru
        if ($surat->kode_arsip_id != $request->kode_arsip_id) {
            $kode = KodeArsip::findOrFail($request->kode_arsip_id);
            $last = SuratMasuk::where('kode_arsip_id', $request->kode_arsip_id)->latest()->first();
            $nomorUrut = $last ? $last->nomor_urut + 1 : 1;
            $nomorRegistrasi = $kode->kode . '/' . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
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
            'tempat'           => $request->tempat,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'jam_mulai'        => $request->jam_mulai,
            'jam_selesai'      => $request->jam_selesai,
            'materi'           => $request->materi,
            'jumlah_peserta'   => $request->jumlah_peserta ?? 0,
            'kursi'            => $request->kursi ?? 0,
            'meja'             => $request->meja ?? 0,
            'proyektor'        => $request->proyektor ?? 0,
            'mic'              => $request->mic ?? 0,
            'sound_system'     => $request->sound_system ?? 0,
            'kabel_roll'       => $request->kabel_roll ?? 0,
            'lainnya'          => $request->lainnya,
        ]);

        // Perbaikan: Cari arsip menggunakan kode_arsip unik lama, bukan menggunakan judul
        Arsip::where('kode_arsip', $oldNomorRegistrasi)->update([
            'kode_arsip'    => $nomorRegistrasi,
            'nama_arsip'    => $request->judul,
            'tanggal_arsip' => $request->tanggal_surat,
            'kategori'      => 'Surat Masuk',
            'file_arsip'    => $file,
        ]);

        return redirect()->route('suratmasuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS SURAT
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
            Storage::disk('public')->delete($surat->file_surat);
        }

        // Perbaikan: Hapus data arsip berdasarkan acuan unik kode_arsip
        Arsip::where('kode_arsip', $surat->nomor_registrasi)->delete();

        Agenda::where('surat_masuk_id', $surat->id)->delete();

        $surat->delete();

        return redirect()->route('suratmasuk.index')->with('success', 'Surat berhasil dihapus.');
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
            'user_disposisi_id' => 'required|exists:users,id', // Ditambahkan pengaman exists
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
    $last = SuratMasuk::where('kode_arsip_id', $id)->latest()->first();
    $nomor = $last ? $last->nomor_urut + 1 : 1;

    // Generate format nomor registrasi secara lengkap
    $nomorLengkap = $kode->kode . '/' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

    return response()->json([
        'nomor_registrasi' => $nomorLengkap
    ]);
}
}