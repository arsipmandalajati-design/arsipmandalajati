<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\SuratKeluar;
use App\Models\Arsip;
use App\Models\KodeArsip;
use App\Models\User;
use App\Models\Notification;

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
        $query = SuratKeluar::with([
            'kodearsip',
            'user',
            'userDisposisi'
        ]);

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_surat', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_surat', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('kode_arsip')) {
            $query->whereHas('kodearsip', function ($q) use ($request) {
                $q->where('kode', 'LIKE', '%' . $request->kode_arsip . '%');
            });
        }

        if ($request->filled('perihal')) {
            $query->where('perihal', 'LIKE', '%' . $request->perihal . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $suratkeluar = $query->latest()->get();

        $kodearsip = KodeArsip::all();

        return view(
            'suratkeluar.index',
            compact(
                'suratkeluar',
                'kodearsip'
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
        $kodearsip = KodeArsip::orderBy('kode')->get();

        return view(
            'suratkeluar.create',
            compact('kodearsip')
        );
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

        $last = SuratKeluar::where(
                'kode_arsip_id',
                $id
            )
            ->whereYear('created_at', $tahun)
            ->latest()
            ->first();

        $nomor = $last
            ? $last->nomor_urut + 1
            : 1;

        $nomorLengkap =
            "ARSIP/KEC-MND/" .
            $kode->kode .
            "." .
            str_pad(
                $nomor,
                3,
                '0',
                STR_PAD_LEFT
            ) .
            "/" .
            $tahun;

        return response()->json([
            'nomor_registrasi' => $nomorLengkap
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN SURAT KELUAR
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
{
    $request->merge([
        'nomor_surat' => trim($request->nomor_surat)
    ]);

    $request->validate([
        'kode_arsip_id' => 'required|exists:kode_arsips,id',
        'nomor_surat'   => 'required|unique:surat_keluars,nomor_surat',
        'judul'         => 'required|max:255',
        'pengirim'      => 'required|max:255',
        'tujuan'        => 'required|max:255',
        'tanggal_surat' => 'required|date',
        'perihal'       => 'required',
        'file_surat'    => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | Generate Nomor Registrasi
        |--------------------------------------------------------------------------
        */

        $kode = KodeArsip::findOrFail($request->kode_arsip_id);

        $tahun = date('Y');

        $last = SuratKeluar::where(
                    'kode_arsip_id',
                    $request->kode_arsip_id
                )
                ->whereYear('created_at',$tahun)
                ->latest()
                ->first();

        $nomorUrut = $last
                        ? $last->nomor_urut + 1
                        : 1;

        $nomorRegistrasi =
            "ARSIP/KEC-MND/" .
            $kode->kode .
            "." .
            str_pad(
                $nomorUrut,
                3,
                '0',
                STR_PAD_LEFT
            ) .
            "/" .
            $tahun;

        /*
        |--------------------------------------------------------------------------
        | Upload File
        |--------------------------------------------------------------------------
        */

        $file = null;

        if ($request->hasFile('file_surat')) {

            $file = $request
                ->file('file_surat')
                ->store(
                    'surat_keluar',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Surat Keluar
        |--------------------------------------------------------------------------
        */

        $surat = SuratKeluar::create([

            'user_id' => Auth::id(),

            'kode_arsip_id' => $request->kode_arsip_id,

            'nomor_urut' => $nomorUrut,

            'nomor_registrasi' => $nomorRegistrasi,

            'nomor_surat' => $request->nomor_surat,

            'judul' => $request->judul,

            'pengirim' => $request->pengirim,

            'tujuan' => $request->tujuan,

            'tanggal_surat' => $request->tanggal_surat,

            'perihal' => $request->perihal,

            'file_surat' => $file,

            'status' => 'Belum ACC',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan ke Arsip
        |--------------------------------------------------------------------------
        */

        Arsip::create([

            'kode_arsip' => $nomorRegistrasi,

            'nama_arsip' => $surat->judul,

            'tanggal_arsip' => $surat->tanggal_surat,

            'kategori' => 'Surat Keluar',

            'file_arsip' => $file,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Notifikasi Admin
        |--------------------------------------------------------------------------
        */

        $admins = User::where(
                    'role',
                    'admin'
                )->get();

        foreach($admins as $admin){

            Notification::create([

                'user_id' => $admin->id,

                'judul' => 'Surat Keluar Baru',

                'pesan' =>
                    Auth::user()->name .
                    ' menambahkan surat keluar "' .
                    $surat->judul .
                    '".',

                'jenis' => 'surat_keluar',

                'reference_id' => $surat->id,

                'is_read' => 0,

            ]);

        }

        DB::commit();

        return redirect()
            ->route('suratkeluar.index')
            ->with(
                'success',
                'Surat keluar berhasil disimpan.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        if (
            $file &&
            Storage::disk('public')->exists($file)
        ) {
            Storage::disk('public')->delete($file);
        }

        return back()
            ->withInput()
            ->withErrors([
                'error' =>
                'Gagal menyimpan data : ' .
                $e->getMessage()
            ]);

    }

}

/*
|--------------------------------------------------------------------------
| FORM EDIT
|--------------------------------------------------------------------------
*/
public function edit($id)
{
    $surat = SuratKeluar::findOrFail($id);

    $kodearsip = KodeArsip::orderBy('kode')->get();

    return view(
        'suratkeluar.edit',
        compact(
            'surat',
            'kodearsip'
        )
    );
}

/*
|--------------------------------------------------------------------------
| UPDATE SURAT KELUAR
|--------------------------------------------------------------------------
*/

public function update(Request $request, $id)
{
    $request->merge([
        'nomor_surat' => trim($request->nomor_surat)
    ]);

    $request->validate([

        'kode_arsip_id' => 'required|exists:kode_arsips,id',

        'nomor_surat' =>
            'required|unique:surat_keluars,nomor_surat,' . $id,

        'judul' => 'required|max:255',

        'pengirim' => 'required|max:255',

        'tujuan' => 'required|max:255',

        'tanggal_surat' => 'required|date',

        'perihal' => 'required',

        'file_surat' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',

    ]);

    DB::beginTransaction();

    try {

        $surat = SuratKeluar::findOrFail($id);

        $oldKode = $surat->nomor_registrasi;

        $tahun = date(
            'Y',
            strtotime($surat->created_at)
        );

        /*
        |--------------------------------------------------------------------------
        | Generate Nomor Registrasi Baru
        |--------------------------------------------------------------------------
        */

        if ($surat->kode_arsip_id != $request->kode_arsip_id) {

            $kode = KodeArsip::findOrFail(
                $request->kode_arsip_id
            );

            $last = SuratKeluar::where(
                        'kode_arsip_id',
                        $request->kode_arsip_id
                    )
                    ->whereYear(
                        'created_at',
                        $tahun
                    )
                    ->latest()
                    ->first();

            $nomorUrut =
                $last
                ? $last->nomor_urut + 1
                : 1;

            $nomorRegistrasi =
                "ARSIP/KEC-MND/" .
                $kode->kode .
                "." .
                str_pad(
                    $nomorUrut,
                    3,
                    '0',
                    STR_PAD_LEFT
                ) .
                "/" .
                $tahun;

        } else {

            $nomorUrut = $surat->nomor_urut;

            $nomorRegistrasi =
                $surat->nomor_registrasi;

        }

        /*
        |--------------------------------------------------------------------------
        | Upload File Baru
        |--------------------------------------------------------------------------
        */

        $file = $surat->file_surat;

        if ($request->hasFile('file_surat')) {

            if (
                $surat->file_surat &&
                Storage::disk('public')->exists(
                    $surat->file_surat
                )
            ) {

                Storage::disk('public')->delete(
                    $surat->file_surat
                );

            }

            $file = $request
                ->file('file_surat')
                ->store(
                    'surat_keluar',
                    'public'
                );

        }

        /*
        |--------------------------------------------------------------------------
        | Update Surat Keluar
        |--------------------------------------------------------------------------
        */

        $surat->update([

            'kode_arsip_id' => $request->kode_arsip_id,

            'nomor_urut' => $nomorUrut,

            'nomor_registrasi' => $nomorRegistrasi,

            'nomor_surat' => $request->nomor_surat,

            'judul' => $request->judul,

            'pengirim' => $request->pengirim,

            'tujuan' => $request->tujuan,

            'tanggal_surat' => $request->tanggal_surat,

            'perihal' => $request->perihal,

            'file_surat' => $file,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Arsip
        |--------------------------------------------------------------------------
        */

        Arsip::where(
            'kode_arsip',
            $oldKode
        )->update([

            'kode_arsip' => $nomorRegistrasi,

            'nama_arsip' => $request->judul,

            'tanggal_arsip' => $request->tanggal_surat,

            'kategori' => 'Surat Keluar',

            'file_arsip' => $file,

        ]);

        DB::commit();

        return redirect()
            ->route('suratkeluar.index')
            ->with(
                'success',
                'Surat keluar berhasil diperbarui.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->withErrors([

                'error' =>
                    'Gagal memperbarui data : ' .
                    $e->getMessage()

            ]);

    }

}

/*
|--------------------------------------------------------------------------
| HAPUS SURAT
|--------------------------------------------------------------------------
*/
public function destroy($id)
{
    $surat = SuratKeluar::findOrFail($id);

    DB::beginTransaction();

    try {

        if (
            $surat->file_surat &&
            Storage::disk('public')->exists($surat->file_surat)
        ) {
            Storage::disk('public')->delete($surat->file_surat);
        }

        Arsip::where(
            'kode_arsip',
            $surat->nomor_registrasi
        )->delete();

        Notification::where(
            'reference_id',
            $surat->id
        )
        ->where(
            'jenis',
            'surat_keluar'
        )
        ->delete();

        $surat->delete();

        DB::commit();

        return redirect()
            ->route('suratkeluar.index')
            ->with(
                'success',
                'Surat keluar berhasil dihapus.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}


/*
|--------------------------------------------------------------------------
| DETAIL SURAT
|--------------------------------------------------------------------------
*/

public function show($id)
{
    $suratkeluar = SuratKeluar::with([

        'kodearsip',

        'user',

        'userDisposisi',

    ])->findOrFail($id);

    return view(
        'suratkeluar.show',
        compact(
            'suratkeluar'
        )
    );
}


/*
|--------------------------------------------------------------------------
| PRINT
|--------------------------------------------------------------------------
*/

public function print()
{
    $suratkeluar = SuratKeluar::with([

        'kodearsip',

        'user',

        'userDisposisi'

    ])
    ->latest()
    ->get();

    return view(
        'suratkeluar.print',
        compact(
            'suratkeluar'
        )
    );
}


/*
|--------------------------------------------------------------------------
| VERIFIKASI ADMIN
|--------------------------------------------------------------------------
*/

public function verifikasi($id)
{
    $surat = SuratKeluar::findOrFail($id);

    $surat->update([

        'status' => 'Belum Disposisi'

    ]);

    Notification::create([

        'user_id' => $surat->user_id,

        'judul' => 'Surat Keluar Diverifikasi',

        'pesan' =>
            'Surat keluar "' .
            $surat->judul .
            '" berhasil diverifikasi Admin.',

        'jenis' => 'surat_keluar',

        'reference_id' => $surat->id,

        'is_read' => 0,

    ]);

    return redirect()
        ->route('suratkeluar.index')
        ->with(
            'success',
            'Surat berhasil diverifikasi.'
        );
}


/*
|--------------------------------------------------------------------------
| FORM DISPOSISI
|--------------------------------------------------------------------------
*/

public function disposisi($id)
{
    $surat = SuratKeluar::with([

        'kodearsip',

        'user',

        'userDisposisi'

    ])->findOrFail($id);

    $users = User::where(
                'role',
                'pegawai'
            )
            ->orderBy('name')
            ->get();

    return view(
        'suratkeluar.disposisi',
        compact(
            'surat',
            'users'
        )
    );
}


/*
|--------------------------------------------------------------------------
| KIRIM DISPOSISI
|--------------------------------------------------------------------------
*/

public function kirimDisposisi(Request $request,$id)
{
    $request->validate([

        'user_disposisi_id' =>
            'required|exists:users,id',

        'catatan_admin' =>
            'required'

    ]);

    $surat = SuratKeluar::findOrFail($id);

    $surat->update([

        'user_disposisi_id' =>
            $request->user_disposisi_id,

        'catatan_admin' =>
            $request->catatan_admin,

        'status' =>
            'Sudah Disposisi'

    ]);

    Notification::create([

        'user_id' =>
            $request->user_disposisi_id,

        'judul' =>
            'Disposisi Surat Keluar',

        'pesan' =>
            'Anda menerima disposisi surat keluar "' .
            $surat->judul .
            '".',

        'jenis' =>
            'surat_keluar',

        'reference_id' =>
            $surat->id,

        'is_read' =>
            0

    ]);

    return redirect()
        ->route('suratkeluar.index')
        ->with(
            'success',
            'Disposisi berhasil dikirim.'
        );
}
}