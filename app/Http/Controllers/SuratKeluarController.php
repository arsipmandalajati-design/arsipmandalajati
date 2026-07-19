<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\SuratKeluar;
use App\Models\Arsip;
use App\Models\KodeArsip;

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

        $suratkeluar = SuratKeluar::with('kodearsip');

        /*
        |--------------------------------------------------------------------------
        | FILTER KODE ARSIP
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kode_arsip')) {

            $suratkeluar->whereHas('kodearsip', function ($q) use ($request) {

                $q->where(
                    'kode',
                    'LIKE',
                    '%' . $request->kode_arsip . '%'
                );

            });

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER PENGIRIM
        |--------------------------------------------------------------------------
        */

        if ($request->filled('pengirim')) {

            $suratkeluar->where(
                'pengirim',
                'LIKE',
                '%' . $request->pengirim . '%'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TUJUAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tujuan')) {

            $suratkeluar->where(
                'tujuan',
                'LIKE',
                '%' . $request->tujuan . '%'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER PERIHAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('perihal')) {

            $suratkeluar->where(
                'perihal',
                'LIKE',
                '%' . $request->perihal . '%'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal_awal')) {

            $suratkeluar->whereDate(
                'tanggal_surat',
                '>=',
                $request->tanggal_awal
            );

        }

        if ($request->filled('tanggal_akhir')) {

            $suratkeluar->whereDate(
                'tanggal_surat',
                '<=',
                $request->tanggal_akhir
            );

        }

        $suratkeluar = $suratkeluar
            ->latest()
            ->get();

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
    | FORM TAMBAH SURAT
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
    | SIMPAN SURAT KELUAR
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([

            'kode_arsip_id' => 'required',

            'nomor_surat'   => 'required',

            'judul'         => 'required',

            'pengirim'      => 'required',

            'tujuan'        => 'required',

            'tanggal_surat' => 'required|date',

            'perihal'       => 'required',

            'file_surat'    => 'required|mimes:pdf|max:2048',

        ]);

        /*
        |--------------------------------------------------------------------------
        | UPLOAD FILE
        |--------------------------------------------------------------------------
        */

        $file = null;

        if ($request->hasFile('file_surat')) {

            $file = $request
                ->file('file_surat')
                ->store('surat', 'public');

        }
                /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA SURAT KELUAR
        |--------------------------------------------------------------------------
        */

        $surat = SuratKeluar::create([

            'user_id'        => Auth::id(),

            'kode_arsip_id'  => $request->kode_arsip_id,

            'nomor_surat'    => $request->nomor_surat,

            'judul'          => $request->judul,

            'pengirim'       => $request->pengirim,

            'tujuan'         => $request->tujuan,

            'tanggal_surat'  => $request->tanggal_surat,

            'perihal'        => $request->perihal,

            'file_surat'     => $file,

        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE TABEL ARSIP
        |--------------------------------------------------------------------------
        */

        Arsip::create([

            'kode_arsip'    => $surat->kodearsip->kode ?? '-',

            'nama_arsip'    => $surat->judul,

            'tanggal_arsip' => $surat->tanggal_surat,

            'kategori'      => 'Surat Keluar',

            'file_arsip'    => $surat->file_surat,

        ]);

        return redirect()

            ->route('suratkeluar.index')

            ->with(
                'success',
                'Data surat keluar berhasil disimpan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(SuratKeluar $suratkeluar)
    {
        $kodearsip = KodeArsip::orderBy('kode')->get();

        return view(
            'suratkeluar.edit',
            [
                'surat'      => $suratkeluar,
                'kodearsip'  => $kodearsip
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, SuratKeluar $suratkeluar)
    {

        $request->validate([

            'kode_arsip_id' => 'required',

            'nomor_surat'   => 'required',

            'judul'         => 'required',

            'pengirim'      => 'required',

            'tujuan'        => 'required',

            'tanggal_surat' => 'required|date',

            'perihal'       => 'required',

            'file_surat'    => 'nullable|mimes:pdf|max:2048',

        ]);

        $file = $suratkeluar->file_surat;

        /*
        |--------------------------------------------------------------------------
        | GANTI FILE BARU
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file_surat')) {

            if (

                $suratkeluar->file_surat &&

                Storage::disk('public')
                    ->exists($suratkeluar->file_surat)

            ) {

                Storage::disk('public')
                    ->delete($suratkeluar->file_surat);

            }

            $file = $request

                ->file('file_surat')

                ->store('surat', 'public');

        }

        $suratkeluar->update([

            'kode_arsip_id' => $request->kode_arsip_id,

            'nomor_surat'   => $request->nomor_surat,

            'judul'         => $request->judul,

            'pengirim'      => $request->pengirim,

            'tujuan'        => $request->tujuan,

            'tanggal_surat' => $request->tanggal_surat,

            'perihal'       => $request->perihal,

            'file_surat'    => $file,

        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA ARSIP
        |--------------------------------------------------------------------------
        */

        Arsip::where(
            'file_arsip',
            $suratkeluar->getOriginal('file_surat')
        )->update([

            'kode_arsip'    => $suratkeluar->kodearsip->kode ?? '-',

            'nama_arsip'    => $request->judul,

            'tanggal_arsip' => $request->tanggal_surat,

            'kategori'      => 'Surat Keluar',

            'file_arsip'    => $file,

        ]);

        return redirect()

            ->route('suratkeluar.index')

            ->with(
                'success',
                'Data surat keluar berhasil diperbarui.'
            );
        }
                /*
    |--------------------------------------------------------------------------
    | HAPUS DATA
    |--------------------------------------------------------------------------
    */

    public function destroy(SuratKeluar $suratkeluar)
    {

        /*
        |--------------------------------------------------------------------------
        | HAPUS FILE PDF
        |--------------------------------------------------------------------------
        */

        if (

            $suratkeluar->file_surat &&

            Storage::disk('public')
                ->exists($suratkeluar->file_surat)

        ) {

            Storage::disk('public')
                ->delete($suratkeluar->file_surat);

        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA ARSIP
        |--------------------------------------------------------------------------
        */

        Arsip::where(
            'file_arsip',
            $suratkeluar->file_surat
        )->delete();

        /*
        |--------------------------------------------------------------------------
        | HAPUS SURAT
        |--------------------------------------------------------------------------
        */

        $suratkeluar->delete();

        return redirect()

            ->route('suratkeluar.index')

            ->with(
                'success',
                'Data surat keluar berhasil dihapus.'
            );

    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL SURAT
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {

        $suratkeluar = SuratKeluar::with('kodearsip')

            ->findOrFail($id);

        return view(

            'suratkeluar.show',

            compact('suratkeluar')

        );

    }

    /*
    |--------------------------------------------------------------------------
    | CETAK DATA
    |--------------------------------------------------------------------------
    */

    public function print()
    {

        $suratkeluar = SuratKeluar::with('kodearsip')

            ->latest()

            ->get();

        return view(

            'suratkeluar.print',

            compact('suratkeluar')

        );

        /*
        |--------------------------------------------------------------------------
        | Jika ingin menggunakan DomPDF
        |--------------------------------------------------------------------------
        |

        $pdf = Pdf::loadView(
            'suratkeluar.print',
            compact('suratkeluar')
        );

        return $pdf->stream(
            'laporan-surat-keluar.pdf'
        );

        */

    }

}
