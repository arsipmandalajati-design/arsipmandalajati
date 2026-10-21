<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;
use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\Notification;

class AgendaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DATA AGENDA
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $agenda = Agenda::with([
            'suratMasuk',
            'user'
        ]);

        // Filter Nama Kegiatan
        if ($request->filled('nama_kegiatan')) {

            $agenda->where(
                'nama_kegiatan',
                'LIKE',
                '%' . $request->nama_kegiatan . '%'
            );

        }

        // Filter Status
        if ($request->filled('status')) {

            $agenda->where(
                'status',
                $request->status
            );

        }

        // Filter Tanggal Awal
        if ($request->filled('tanggal_awal')) {

            $agenda->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_awal
            );

        }

        // Filter Tanggal Akhir
        if ($request->filled('tanggal_akhir')) {

            $agenda->whereDate(
                'tanggal',
                '<=',
                $request->tanggal_akhir
            );

        }

        /*
        |--------------------------------------------------------------------------
        | ROLE PEGAWAI
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->role == 'pegawai') {

            $agenda->where('user_id', Auth::id());

        }

        $agenda = $agenda
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA SURAT SIAP AGENDA
        |--------------------------------------------------------------------------
        */

        if (Auth::user()->role == 'pegawai') {

            $surats = SuratMasuk::where(
                'user_disposisi_id',
                Auth::id()
        )
        ->where(
                'status',
                'Siap Dijadikan Agenda'
        )
        ->get();

        } else {

            $surats = collect();

        }

        return view(
            'agenda.index',
            compact(
                'agenda',
                'surats'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM BUAT AGENDA
    |--------------------------------------------------------------------------
    */

    public function create($id)
    {
        $surat = SuratMasuk::with('pejabat')->findOrFail($id);

        if (
            Auth::user()->role == 'pegawai' &&
            $surat->user_disposisi_id != Auth::id()
        ) {
            abort(403);
        }

        if ($surat->status != 'Sudah Disposisi') {
            return redirect()
                ->route('suratmasuk.index')
                ->with('error', 'Surat belum dapat dijadikan agenda.');

        }

        return view(
            'agenda.create',
            compact('surat')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN AGENDA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request, $id)
    {
        $request->validate([

            'tanggal'       => 'required|date',
            'jam_mulai'     => 'required',
            'jam_selesai'   => 'required',
            'tempat'        => 'required',

            'dokumentasi'   => 'nullable|image|max:4096',

            'kursi'         => 'nullable|integer|min:0',
            'meja'          => 'nullable|integer|min:0',
            'proyektor'     => 'nullable|integer|min:0',
            'mic'           => 'nullable|integer|min:0',
            'sound_system'  => 'nullable|integer|min:0',
            'kabel_roll'    => 'nullable|integer|min:0',
            'lainnya'       => 'nullable|string',

        ]);

        $surat = SuratMasuk::with('pejabat')->findOrFail($id);

        if (
            Auth::user()->role == 'pegawai' &&
            $surat->user_disposisi_id != Auth::id()
        ) {
            abort(403);
        }

        if ($surat->status == 'Sudah Dijadikan Agenda') {

            return redirect()
                ->route('agenda.index')
                ->with(
                    'error',
                    'Agenda untuk surat ini sudah pernah dibuat.'
                );

        }

        /*
        |--------------------------------------------------------------------------
        | Upload Dokumentasi
        |--------------------------------------------------------------------------
        */

        $dokumentasi = null;

        if ($request->hasFile('dokumentasi')) {

            $dokumentasi = $request
                ->file('dokumentasi')
                ->store('dokumentasi', 'public');

        }
                /*
        |--------------------------------------------------------------------------
        | CEK BOOKING RUANG
        |--------------------------------------------------------------------------
        */

        $booking = Agenda::whereDate(
            'tanggal',
            $request->tanggal
        )
        ->where(
            'tempat',
            $request->tempat
        )
        ->where(
            'status',
            '!=',
            'Ditunda'
        )
        ->where(function ($q) use ($request) {

            $q->whereBetween(
                'jam_mulai',
                [
                    $request->jam_mulai,
                    $request->jam_selesai
                ]
            )

            ->orWhereBetween(
                'jam_selesai',
                [
                    $request->jam_mulai,
                    $request->jam_selesai
                ]
            )

            ->orWhere(function ($qq) use ($request) {

                $qq->where(
                        'jam_mulai',
                        '<=',
                        $request->jam_mulai
                    )
                    ->where(
                        'jam_selesai',
                        '>=',
                        $request->jam_selesai
                    );

            });

        })

        ->first();

if ($booking) {

return back()

    ->withInput()

    ->with(

        'booking_error',

        'Tempat '

        . $booking->tempat

        . ' sudah digunakan pada '

        . $booking->tanggal

        . ' pukul '

        . $booking->jam_mulai

        . ' - '

        . $booking->jam_selesai

    );

}

/*
|--------------------------------------------------------------------------
| SIMPAN AGENDA
|--------------------------------------------------------------------------
*/

$agenda = Agenda::create([

    'surat_masuk_id' => $id,

    'user_id' => Auth::id(),

    'nama_kegiatan' => $surat->judul,

    'tanggal' => $request->tanggal,

    'jam_mulai' => $request->jam_mulai,

    'jam_selesai' => $request->jam_selesai,

    'tempat' => $request->tempat,

    'materi' => $surat->materi,

    'penyelenggara' => $surat->pengirim,

    'status' => 'Terjadwal',

    'keterangan' => $surat->perihal,

    'dokumentasi' => $dokumentasi,

    'kursi' => $request->kursi,

    'meja' => $request->meja,

    'proyektor' => $request->proyektor,

    'mic' => $request->mic,

    'sound_system' => $request->sound_system,

    'kabel_roll' => $request->kabel_roll,

    'lainnya' => $request->lainnya,

]);

/*
|--------------------------------------------------------------------------
| UPDATE STATUS SURAT
|--------------------------------------------------------------------------
*/

$surat->update([

'status' => 'Sudah Dijadikan Agenda'

]);

/*
|--------------------------------------------------------------------------
| NOTIFIKASI ADMIN
|--------------------------------------------------------------------------
*/

$admins = User::where('role', 'admin')->get();

foreach ($admins as $admin) {

Notification::create([

    'user_id'     => $admin->id,

    'judul'        => 'Agenda Baru',

    'pesan'        => Auth::user()->name .
                      ' membuat agenda "' .
                      $agenda->nama_kegiatan .
                      '".',

    'jenis'        => 'agenda',

    'reference_id' => $agenda->id,

    'is_read'      => 0,

]);

}

return redirect()

->route('agenda.index')

->with(

    'success',

    'Agenda berhasil dibuat.'

);

}

    /*
    |--------------------------------------------------------------------------
    | EDIT AGENDA
    |--------------------------------------------------------------------------
    */
    public function edit(Agenda $agenda)
    {
        // Pegawai hanya boleh mengedit agenda miliknya
        if (
            Auth::user()->role == 'pegawai' &&
            $agenda->user_id != Auth::id()
        ) {
            abort(403);
        }

        return view(
            'agenda.edit',
            compact('agenda')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE AGENDA
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Agenda $agenda)
    {
        // Pegawai hanya boleh mengedit agenda miliknya
        if (
            Auth::user()->role == 'pegawai' &&
            $agenda->user_id != Auth::id()
        ) {
            abort(403);
        }

        $request->validate([

            'nama_kegiatan' => 'required',

            'tanggal' => 'required|date',

            'jam_mulai' => 'required',

            'jam_selesai' => 'required',

            'tempat' => 'required',

            'penyelenggara' => 'required',

            'status' => 'required',

            'materi' => 'nullable',

            'dokumentasi' => 'nullable|image|max:4096',

        ]);

        /*
        |--------------------------------------------------------------------------
        | CEK BOOKING (SELAIN AGENDA INI)
        |--------------------------------------------------------------------------
        */

        $booking = Agenda::whereDate('tanggal', $request->tanggal)

            ->where('tempat', $request->tempat)

            ->where('status', '!=', 'Ditunda')

            ->where('id', '!=', $agenda->id)

            ->where(function ($q) use ($request) {

                $q->whereBetween(
                    'jam_mulai',
                    [
                        $request->jam_mulai,
                        $request->jam_selesai
                    ]
                )

                ->orWhereBetween(
                    'jam_selesai',
                    [
                        $request->jam_mulai,
                        $request->jam_selesai
                    ]
                )

                ->orWhere(function ($qq) use ($request) {

                    $qq->where(
                            'jam_mulai',
                            '<=',
                            $request->jam_mulai
                        )

                        ->where(
                            'jam_selesai',
                            '>=',
                            $request->jam_selesai
                        );

                });

            })

            ->first();

        if ($booking) {

            return back()

                ->withInput()

                ->with(
                    'booking_error',
                    'Tempat "' .
                    $booking->tempat .
                    '" sudah digunakan pada tanggal ' .
                    $booking->tanggal .
                    ' pukul ' .
                    $booking->jam_mulai .
                    ' - ' .
                    $booking->jam_selesai
                );

        }

        /*
        |--------------------------------------------------------------------------
        | UPLOAD DOKUMENTASI BARU
        |--------------------------------------------------------------------------
        */

        $dokumentasi = $agenda->dokumentasi;

        if ($request->hasFile('dokumentasi')) {

            $dokumentasi = $request->file('dokumentasi')
                ->store('dokumentasi', 'public');

        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA AGENDA
        |--------------------------------------------------------------------------
        */
        
$agenda->update([

    'nama_kegiatan'=>$request->nama_kegiatan,
    'penyelenggara'=>$request->penyelenggara,
    'tanggal'=>$request->tanggal,
    'jam_mulai'=>$request->jam_mulai,
    'jam_selesai'=>$request->jam_selesai,
    'status'=>$request->status,
    'tempat'=>$request->tempat,
    'materi'=>$request->materi,
    'keterangan'=>$request->keterangan,

    'hasil_kegiatan'=>$request->hasil_kegiatan,
    'hasil_materi'=>$request->hasil_materi,
    'catatan'=>$request->catatan,

    'kursi'=>$request->kursi,
    'meja'=>$request->meja,
    'proyektor'=>$request->proyektor,
    'mic'=>$request->mic,
    'sound_system'=>$request->sound_system,
    'kabel_roll'=>$request->kabel_roll,
    'lainnya'=>$request->lainnya,

    'dokumentasi'=>$dokumentasi

]);

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI ADMIN
        |--------------------------------------------------------------------------
        */

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {

            Notification::create([

                'user_id' => $admin->id,

                'judul' => 'Agenda Diperbarui',

                'pesan' => 'Agenda "' .
                          $agenda->nama_kegiatan .
                          '" berhasil diperbarui.',

                'jenis' => 'agenda',

                'reference_id' => $agenda->id,

                'is_read' => 0,

            ]);

        }

        return redirect()

            ->route('agenda.index')

            ->with(
                'success',
                'Agenda berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS AGENDA
    |--------------------------------------------------------------------------
    */

    public function destroy(Agenda $agenda)
    {
        // Pegawai hanya boleh menghapus agenda miliknya
        if (
            Auth::user()->role == 'pegawai' &&
            $agenda->user_id != Auth::id()
        ) {
            abort(403);
        }

        // Kembalikan status surat jika agenda dihapus
        if ($agenda->surat_masuk_id) {

            $surat = SuratMasuk::find($agenda->surat_masuk_id);

            if ($surat) {

                $surat->update([

                    'status' => 'Sudah Disposisi'

                ]);

            }

        }

        $agenda->delete();

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI ADMIN
        |--------------------------------------------------------------------------
        */

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {

            Notification::create([

                'user_id' => $admin->id,

                'judul' => 'Agenda Dihapus',

                'pesan' => 'Agenda "' .
                            $agenda->nama_kegiatan .
                            '" telah dihapus.',

                'jenis' => 'agenda',

                'reference_id' => null,

                'is_read' => 0,

            ]);

        }

        return redirect()

            ->route('agenda.index')

            ->with(
                'success',
                'Agenda berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CETAK AGENDA
    |--------------------------------------------------------------------------
    */

    public function print()
{
    $agenda = Agenda::latest()->get();

    return view('agenda.print', compact('agenda'));
}

    /*
|--------------------------------------------------------------------------
| KIRIM WHATSAPP
|--------------------------------------------------------------------------
*/

public function whatsapp(Agenda $agenda)
{
    $pesan = "";

    $pesan .= "*PERMINTAAN SARANA KEGIATAN*%0A%0A";

    $pesan .= "Nama Kegiatan : "
            .$agenda->nama_kegiatan
            ."%0A";

    $pesan .= "Tanggal : "
            .$agenda->tanggal
            ."%0A";

    $pesan .= "Jam : "
            .$agenda->jam_mulai
            ." - "
            .$agenda->jam_selesai
            ."%0A";

    $pesan .= "Tempat : "
            .$agenda->tempat
            ."%0A%0A";

    $pesan .= "*Kebutuhan Sarana*%0A";

    if($agenda->kursi > 0){

        $pesan .= "🪑 Kursi : "
                .$agenda->kursi
                ."%0A";

    }

    if($agenda->meja > 0){

        $pesan .= "🪑 Meja : "
                .$agenda->meja
                ."%0A";

    }

    if($agenda->proyektor > 0){

        $pesan .= "📽 Proyektor : "
                .$agenda->proyektor
                ."%0A";

    }

    if($agenda->mic > 0){

        $pesan .= "🎤 Microphone : "
                .$agenda->mic
                ."%0A";

    }

    if($agenda->sound_system > 0){

        $pesan .= "🔊 Sound System : "
                .$agenda->sound_system
                ."%0A";

    }

    if($agenda->kabel_roll > 0){

        $pesan .= "🔌 Kabel Roll : "
                .$agenda->kabel_roll
                ."%0A";

    }

    if($agenda->lainnya){

        $pesan .= "Lainnya : "
                .$agenda->lainnya
                ."%0A";

    }

    /*
    |--------------------------------------------------------------------------
    | GANTI NOMOR TUJUAN SARPRAS
    |--------------------------------------------------------------------------
    */

    $nomor = "628xxxxxxxxxx";

    $url =
        "https://wa.me/"
        .$nomor
        ."?text="
        .$pesan;

    return redirect($url);
}

/*
|--------------------------------------------------------------------------
| CEK BOOKING RUANG (AJAX)
|--------------------------------------------------------------------------
*/

public function cekBooking(Request $request)
{
    // Logika pengecekan bentrok yang disesuaikan dengan kolom 'tanggal'
    $bentrok = Agenda::where('tempat', $request->tempat)
        ->where('tanggal', $request->tanggal) // <-- Diubah dari tanggal_kegiatan menjadi tanggal
        ->where(function($query) use ($request) {
            $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhere(function($q) use ($request) {
                      $q->where('jam_mulai', '<=', $request->jam_mulai)
                        ->where('jam_selesai', '>=', $request->jam_selesai);
                  });
        })->exists();

    // Mengembalikan response dalam bentuk JSON agar bisa dibaca AJAX
    return response()->json([
        'bentrok' => $bentrok
    ]);
}

public function show($id)
{
    // Diperbarui dengan with('suratMasuk') agar relasi surat asal ikut terbawa
    $agenda = Agenda::with('suratMasuk')->findOrFail($id);

    return view(
        'agenda.show',
        compact('agenda')
    );
}

/*
|--------------------------------------------------------------------------
| HALAMAN HASIL AGENDA
|--------------------------------------------------------------------------
*/

public function hasil($id)
{
    $agenda = Agenda::findOrFail($id);

    return view(
        'agenda.hasil',
        compact('agenda')
    );
}

/*
|--------------------------------------------------------------------------
| SIMPAN HASIL AGENDA
|--------------------------------------------------------------------------
*/

public function simpanHasil(Request $request, $id)
{

    $request->validate([

        'hasil_kegiatan' => 'required',
    
        'hasil_materi' => 'nullable',
    
        'catatan' => 'nullable',
    
        'dokumentasi' => 'nullable|image|max:4096',
    
    ]);

    $agenda = Agenda::findOrFail($id);

    $dokumentasi = $agenda->dokumentasi;

    if ($request->hasFile('dokumentasi')) {

        $dokumentasi = $request
            ->file('dokumentasi')
            ->store('dokumentasi', 'public');

    }

    $agenda->update([

        'hasil_kegiatan' => $request->hasil_kegiatan,

        'hasil_materi'   => $request->hasil_materi,

        'catatan'        => $request->catatan,

        'dokumentasi'    => $dokumentasi,

        'status'         => 'Selesai',

    ]);
    
    return redirect()
    ->route('agenda.index')
    ->with('success', 'Hasil kegiatan berhasil disimpan.');
}

}