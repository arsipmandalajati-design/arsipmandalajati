<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pejabat;
use App\Models\Arsip;
use App\Models\Agenda;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalArsip       = Arsip::count();
        $totalAgenda      = Agenda::count();
        $totalUser        = User::count();
        $totalPejabat     = Pejabat::count();
    
        // Agenda Besok
        $agendaBesok = Agenda::whereDate(
                'tanggal',
                Carbon::tomorrow()
            )
            ->where('status','Terjadwal')
            ->get();
    
        // Chart Surat Masuk
        $chart = DB::table('surat_masuks')
            ->selectRaw('MONTH(tanggal_surat) as bulan, COUNT(*) as total')
            ->groupByRaw('MONTH(tanggal_surat)')
            ->pluck('total','bulan');
    
        $dataChart = [];
    
        for($i=1;$i<=12;$i++){
            $dataChart[] = $chart[$i] ?? 0;
        }
    
        // Aktivitas Terbaru
        $aktivitas = collect()
    
            ->merge(
                SuratMasuk::latest()->take(3)->get()->map(function($item){
                    return [
                        'icon'=>'bi-envelope-fill',
                        'warna'=>'success',
                        'judul'=>'Surat Masuk',
                        'isi'=>$item->judul,
                        'waktu'=>$item->created_at
                    ];
                })
            )
    
            ->merge(
                SuratKeluar::latest()->take(3)->get()->map(function($item){
                    return [
                        'icon'=>'bi-send-fill',
                        'warna'=>'primary',
                        'judul'=>'Surat Keluar',
                        'isi'=>$item->judul,
                        'waktu'=>$item->created_at
                    ];
                })
            )
    
            ->merge(
                Agenda::latest()->take(3)->get()->map(function($item){
                    return [
                        'icon'=>'bi-calendar-event-fill',
                        'warna'=>'warning',
                        'judul'=>'Agenda',
                        'isi'=>$item->nama_kegiatan,
                        'waktu'=>$item->created_at
                    ];
                })
            )
    
            ->merge(
                Arsip::latest()->take(3)->get()->map(function($item){
                    return [
                        'icon'=>'bi-folder-fill',
                        'warna'=>'info',
                        'judul'=>'Arsip',
                        'isi'=>$item->nama_arsip,
                        'waktu'=>$item->created_at
                    ];
                })
            )
    
            ->sortByDesc('waktu')
            ->take(6);
    
            $hour = now()->hour;

            if ($hour >= 5 && $hour < 11) {

                $greeting = "☀️ Selamat Pagi";

            } elseif ($hour >= 11 && $hour < 15) {

                $greeting = "🌤 Selamat Siang";

            } elseif ($hour >= 15 && $hour < 18) {

                $greeting = "🌥 Selamat Sore";

            } else {

                $greeting = "🌙 Selamat Malam";

            }

            {
                return view('dashboard', compact(

                    'totalSuratMasuk',
                    'totalSuratKeluar',
                    'totalArsip',
                    'totalAgenda',
                    'totalUser',
                    'totalPejabat',
                    'aktivitas',
                    'agendaBesok',
                    'greeting'
                    
                    ));
            }
    }
}