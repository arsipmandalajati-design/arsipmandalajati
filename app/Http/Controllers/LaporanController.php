<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\KodeArsip;

class LaporanController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::count();
        $suratKeluar = SuratKeluar::count();
        $arsip = KodeArsip::count();

        $suratMasuk = SuratMasuk::with('kodearsip')->get();

        $suratKeluar = SuratKeluar::with('kodearsip')->get();

        $arsip = KodeArsip::all();

        return view('laporan.index', compact(
            'suratMasuk',
            'suratKeluar',
            'arsip'
        ));

    }

    public function print()
    {
        $suratMasuk = SuratMasuk::all();
        $suratKeluar = SuratKeluar::all();
        $arsip = KodeArsip::all();
    
        $logo = asset('images/logo.png');
    
        return view('laporan.print', compact(
            'suratMasuk',
            'suratKeluar',
            'arsip',
            'logo'
        ));
    }
}